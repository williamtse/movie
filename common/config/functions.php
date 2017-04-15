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
    $api = "https://api.douban.com/v2/movie/subject/$id";
    $json = @file_get_contents($api);
    $info = json_decode($json,true);
    if(!$json) return false;
    Douban_Movie2Db($info);
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