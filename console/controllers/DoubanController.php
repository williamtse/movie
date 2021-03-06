<?php
namespace console\controllers;
use app\components\Multicurl;
use common\models\Movie;
use common\models\MovieActor;
use app\components\Simpledom;
use common\models\Actor;
use common\models\Director;
use common\models\MovieDirector;
use common\models\Category;
use common\models\MovieCategory;
use console\components\Curl;

/**
 * Created by PhpStorm.
 * User: Xie
 * Date: 2017/4/15
 * Time: 17:37
 */
class DoubanController extends \yii\console\Controller
{
    public function actionFetchMovieTop250(){
        console_log("采集开始");
//        $multi_curl = new Multicurl();
//        $multi_curl->maxThread = 50;
//        $mids = [];
//        for($page=0;$page<10;$page++){
//            $start = $page*25;
//            $url = "https://www.douban.com/doulist/380312/?start=$start&sort=time&sub_type=";
//            $multi_curl->add([
//                'url'=>$url,
//                'args'=>[
//                    'page'=>$page,
//                    'url'=>$url,
//                    'mids'=>&$mids
//                ],
//                'opt'=>[
//                    CURLOPT_SSL_VERIFYHOST => 0,
//                    CURLOPT_SSL_VERIFYPEER => 0,
//                    CURLOPT_HEADER => 0,
//                    CURLOPT_FOLLOWLOCATION => 1,
//                    CURLOPT_VERBOSE => 1
//                ],
//            ],function($res,$args){
//                console_log("解析top250第".($args['page']+1)."页");
//                $dom = Simpledom::get_dom_from_string($res['content']);
//                $items = $dom->find('.doulist-item');
//                console_log(count($items));
//                foreach($items as $item){
//                    $href = $item->find('.title',0)->find('a',0)->getAttribute('href');
//                    $arr = explode('/',$href);
//                    $mid = $arr[4];
//                    $args['mids'][]=$mid;
//                    console_log($args['page'].'|'.$mid);
////                    $this->_fetchOneMovie($mid);
//                }
//            });
//        }
//        $multi_curl->start();
        $mids = [];
        for($page=0;$page<10;$page++){
            $content = file_get_contents('html/'.$page.'.html');
            $dom = Simpledom::get_dom_from_string($content);
            $items = $dom->find('.doulist-item');
            foreach($items as $item) {
                $href = $item->find('.title', 0)->find('a', 0)->getAttribute('href');
                $arr = explode('/', $href);
                $mid = $arr[4];
                $mids[] = $mid;
            }
        }
        $multi_curl2 = new Multicurl();
        $multi_curl2->maxThread = 100;
        var_dump($mids);
        foreach($mids as $mid){
            $url = "https://movie.douban.com/subject/$mid";
            $randomIp = $this->_randomIp();
            $multi_curl2->add([
                'url'=>$url,
                'args'=>[
                    'page'=>$page,
                    'url'=>$url,
                    'mid'=>$mid
                ],
                'opt'=>[
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HEADER => 0,
                    CURLOPT_FOLLOWLOCATION => 1,
                    CURLOPT_VERBOSE => 1,
                    CURLOPT_HTTPHEADER => [
                        'CLIENT-IP:'.$randomIp,
                        'X-FORWARDED-FOR:'.$randomIp,
                    ]
                ],
            ],function($res,$args){
                console_log("开始采集".$args['url']);
                file_put_contents('html/'.$args['mid'].'.html',$res['content']);
                $this->_fetchOneMovie($args['mid'],$res['content']);
                console_log("{$args['mid']}采集完成");
            });
        }
        $multi_curl2->start();
        console_log("采集结束");
    }
    public function actionFetchOneMovie($mid){
        $this->_fetchOneMovie($mid);
    }
    protected function _randomIp(){
        return rand(1,255).'.'.rand(1,255).'.'.rand(1,255).'.'.rand(1,255);
    }
    protected function _get($url){
        $ch = curl_init();
        $url = "https://movie.douban.com/subject/1300572";
        $header = array(
            'CLIENT-IP:58.68.44.61',
            'X-FORWARDED-FOR:58.68.44.61',
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $page_content = curl_exec($ch);
        curl_close($ch);
        echo $page_content;
    }
    public function actionTest(){
        $url = "https://movie.douban.com/subject/1300572";
        $res = $this->_get($url);
        var_dump($res);
    }
    protected function _fetchOneMovie($mid,$str){
        $dom = Simpledom::get_dom_from_string($str);
        $info = $dom->find('#info',0);
        //标题
        $name = trim($dom->find('span[property="v:itemreviewed"]',0)->plaintext);
        $title = $dom->find('h1',0)->plaintext;
        $a1 = explode('(',$title);
        $a2 = explode(')',$a1[1]);
        $year = trim($a2[0]);
        console_log("年份：$year");
        console_log("标题：$title");
        //上映时间
        $showTimes = [];
        foreach($dom->find('span[property="v:initialReleaseDate"]') as $releaseDate){
            $showTimes[]=trim($releaseDate->plaintext);
        }
        $showTime= implode('/',$showTimes);
        console_log("上映时间：$showTime");
        //剧情简介
        $summary = $dom->find('span[property="v:summary"]',0)->plaintext;
        $attrs = $info->find('.attrs');
        //海报
        $poster_div = $dom->find('#mainpic',0);
        $poster_img = $poster_div->find('img',0);
        $poster_src = $poster_img->getAttribute('src');
        $poster = get_filename($poster_src);
        //导演
        $director_attr = $attrs[0];
        $directors = [];
        foreach($director_attr->find('a') as $director_link){
            $director_href = $director_link->getAttribute('href');
            $director_id = explode('/',$director_href)[2];
            $director_name= trim($director_link->plaintext);
            console_log("导演：$director_name | $director_id");
            $director_avatar = $this->_get_pepoe_info($director_id);
            $directors[]=[
                'avatar'=>$director_avatar,
                'name'=>$director_name,
                'id'=>$director_id
            ];
        }

        //演员
        if(isset($attrs[2])){
            $actor_attr = $attrs[2];
            $actors = [];
            foreach($actor_attr->find('a') as $actor_link){
                $actor_href = $actor_link->getAttribute('href');
                $actor_id = explode('/',$actor_href)[2];
                $actor_name= trim($actor_link->plaintext);
                console_log("演员：$actor_name | $actor_id");
                $actor_avatar = $this->_get_pepoe_info($actor_id);
                $actors[]=[
                    'avatar'=>$actor_avatar,
                    'name'=>$actor_name,
                    'id'=>$actor_id
                ];
            }
        }

        //类型
        $categories = [];
        foreach($dom->find('span[property="v:genre"]') as $category_span){
            $category_name = trim($category_span->plaintext);
            console_log($category_name);
            $categories[]=$category_name;
        }

        //豆瓣评分
//        $average = floatval(trim($dom->find('strong[property="v:average"]',0)->plaintext));
        //创建电影
        $movie = Movie::findOne($mid);
        if(!$movie){
            $movie = new Movie();
            $movie->id = $mid;
            $movie->created_at = time();
        }else{
            $movie->updated_at = time();
        }
        $movie->title = $title;
        $movie->poster = $poster;
        $movie->name = $name;
        $movie->year = $year;
        $movie->content = $summary;
        $movie->type = 'movie';
        if($movie->save()){
            //新建或更新演员
            foreach($actors as $cast){
                $actor = Actor::findOne(['id'=>$cast['id']]);
                if(!$actor){
                    $actor = new Actor();
                    $actor -> id = $cast['id'];
                }
                $actor->name=$cast['name'];
                $actor->avatar = $cast['avatar'];
                if($actor->save()){
                    $movie_actor = MovieActor::findOne(['mid'=>$mid,'aid'=>$cast['id']]);
                    if(!$movie_actor){
                        $movie_actor = new MovieActor();
                        $movie_actor->mid = $mid;
                        $movie_actor->aid = $cast['id'];
                        $movie_actor->save();
                    }
                }else{
                    console_log(__LINE__);
                    var_dump($actor->avatar);
                    var_dump($actor->errors);exit();
                }

            }
            //新建或更新导演
            foreach($directors as $d){
                $director = Director::findOne($d['id']);
                if(!$director){
                    $director = new Director();
                    $director->id = $d['id'];
                }
                $director->name = $d['name'];
                $avatar = $d['avatar'];
                $director->avatar = $avatar;
                if($director->save()){
                    $movie_director = MovieDirector::findOne(['mid'=>$mid,'did'=>$d['id']]);
                    if(!$movie_director){
                        $movie_director = new MovieDirector();
                        $movie_director->mid = $mid;
                        $movie_director->did = $d['id'];
                        $movie_director->save();
                    }
                }else{
                    console_log(__LINE__);
                    var_dump($director->errors);exit();
                }
            }
            //分类
            foreach($categories as $c){
                $category = Category::findOne(['name'=>$c]);
                if(!$category){
                    $category = new Category();
                    $category->name = $c;
                    $category->created_at = time();
                    $category->save();
                }
                $cid = $category->id;
                $movie_category = MovieCategory::findOne(['cid'=>$cid,'mid'=>$mid]);
                if(!$movie_category){
                    $movie_category = new MovieCategory();
                    $movie_category->cid = $cid;
                    $movie_category->mid = $mid;
                    $movie_category->created_at = time();
                    $movie_category->save();
                }
            }
        }
    }
    protected function _get_pepoe_info($id){
        $url = "https://movie.douban.com/celebrity/$id";
        $dom = @Simpledom::get_dom($url);
        if(!$dom) return null;
        $info_div = $dom->find('#headline',0);
        $img = $info_div->find('img',0);
        $img_src = $img->getAttribute('src');
        $avatar = get_filename($img_src);
        return $avatar;
    }
}