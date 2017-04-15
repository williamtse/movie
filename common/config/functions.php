<?php
/**
 * Created by PhpStorm.
 * User: Xie
 * Date: 2017/4/15
 * Time: 16:03
 */
use common\models\Movie;
use common\models\DoubanRating;
use common\models\Actor;
use common\models\Director;
use common\models\MovieActor;
use common\models\MovieDirector;
use common\models\Category;
use common\models\MovieCategory;
use backend\components\Simpledom;

function console_log($msg, $level = 0) {
    $os = PHP_OS;
    $tab = '';
    if ($level > 0) {
        for ($i = 1; $i < $level * 2 + 1; $i++) {
            $tab .= ' ';
        }
    }
    if ($os == 'WINNT') {
        echo iconv('UTF-8', 'GBK', "$tab$msg\n");
    } else {
        echo "$tab$msg\n";
    }
}
function _get_pepoe_info($id){
    $url = "https://movie.douban.com/celebrity/$id";
    $dom = @Simpledom::get_dom($url);
    if(!$dom) return null;
    $info_div = $dom->find('#headline',0);
    $img = $info_div->find('img',0);
    $img_src = $img->getAttribute('src');
    $avatar = get_filename($img_src);
    return $avatar;
}
function _fetchOneMovie($mid){
    $url = "https://movie.douban.com/subject/$mid";
    $dom = Simpledom::get_dom($url);
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
        $director_avatar = _get_pepoe_info($director_id);
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
            $actor_avatar = _get_pepoe_info($actor_id);
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
function Douban_movie250(){
    $count = 50;//一次去50条
    for($start=0;$start<5;$start++){
        $api = "https://api.douban.com/v2/movie/top250?start=$start&count=$count";
        $contents = file_get_contents($api);
        $arr = json_decode($contents,true);
        $subjects = $arr['subjects'];
        foreach($subjects as $subject){
            console_log("{$subject['id']}|{$subject['title']}");
            Douban_FetchMovie($subject['id']);
        }
    }
}

/**
 * 保存豆瓣电影到数据库
 * @param $info
 */
function Douban_Movie2Db($info){
    $posters = $info['images'];
    $poster = get_filename($posters['small']);
    $mid = $info['id'];
    $movie = Movie::findOne($mid);
    if(!$movie){
        $movie = new Movie();
        $movie->id = $mid;
        $movie->created_at = time();
    }else{
        $movie->updated_at = time();
    }
    $movie->title = $info['title'];
    $movie->poster = $poster;
    $movie->name = $info['title'];
    $movie->year = $info['year'];
    if(isset($info['aka']))
    $movie->other_names = json_encode($info['aka']);
    $movie->content = substr($info['summary'],0,strrpos($info['summary'],'©'));
    $movie->type = $info['subtype'];
    if($movie->save()){
        //豆瓣评分
        $rating = DoubanRating::findOne(['mid'=>$mid]);
        if(!$rating){
            $rating = new DoubanRating();
            $rating->mid = $mid;
        }
        $rating->reviews_count = $info['reviews_count'];
        $rating->wish_count = $info['wish_count'];
        $rating->average = $info['rating']['average'];
        $rating->stars = $info['rating']['stars'];
        $rating->comments_count = $info['comments_count'];
        $rating->ratings_count = $info['ratings_count'];
        $rating->save();

        //演员
        $actors = $info['casts'];
        foreach($actors as $cast){
            $actor = Actor::findOne(['id'=>$cast['id']]);
            if(!$actor){
                $actor = new Actor();
                $actor -> id = $cast['id'];
            }
            $actor->name=$cast['name'];
            $actor->avatar = get_filename($cast['avatars']['small']);
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

        //导演
        $directors = $info['directors'];
        if($directors){
            foreach($directors as $d){
                $director = Director::findOne($d['id']);
                if(!$director){
                    $director = new Director();
                    $director->id = $d['id'];
                }
                $director->name = $d['name'];
                $avatar = get_filename($d['avatars']['small']);
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
        }

        //分类
        $cates = $info['genres'];
        foreach($cates as $c){
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

    }else{
        var_dump($movie->errors);exit();
    }
}

/**
 * 从豆瓣获取电影信息
 * @param $id 电影id
 */

function Douban_FetchMovie($id){
    _fetchOneMovie($id);
}

function get_filename($path){
    return substr($path,strrpos($path,'/')+1);
}
/**
 * @param $filename
 * @param $type i:small l:large s:medium
 * @return string
 */
function Douban_GetPoster($filename,$type){
    $src = "https://img1.doubanio.com/view/movie_poster_cover/{$type}pst/public/$filename";
    return $src;
}

/**
 * @param $filename
 * @param $type small large medium
 * @return string
 */
function Douban_GetAvatar($filename,$type){
    return "https://img5.doubanio.com/img/celebrity/$type/$filename";
}