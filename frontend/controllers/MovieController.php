<?php
/**
 * Created by PhpStorm.
 * User: Xie
 * Date: 2017/4/13
 * Time: 23:25
 */

namespace frontend\controllers;
use common\models\Movie;
use common\models\Category;
use common\models\MovieBt;
use yii\web\Controller;
use Yii;
use common\models\MovieDirector;
use common\models\Actor;
use common\models\Director;

class MovieController extends Controller
{
    public $breadcrumbs=[];
    public $rows=15;
    public $page=1;
    public $limit='';
    public $tags=[];
    public function init()
    {
        parent::init();
        $this->breadcrumbs[]=[
            'label'=>'电影',
            'url'=>'/movie/index'
        ];
        $this->rows = Yii::$app->request->get('rows',$this->rows);
        $this->page = Yii::$app->request->get('page',$this->page);
        $this->limit = "LIMIT ".($this->page-1)*$this->rows.",{$this->rows}";
        $sql = "SELECT count(mc.cid) as total,c.name,c.id FROM movie_category mc LEFT JOIN category c 
                ON c.id=mc.cid GROUP BY mc.cid";
        $cmd = \Yii::$app->db->createCommand($sql);
        $this->tags = $cmd->queryAll();
    }

    public function actionIndex(){
        $sql = "SELECT m.* FROM movie m {$this->limit}";
        $cmd = \Yii::$app->db->createCommand($sql);
        $movies = $cmd->queryAll();
        return $this->render('index',[
            'movies'=>$movies,
            'breadcrumbs'=>$this->breadcrumbs,
            'tags'=>$this->tags
        ]);
    }
    public function actionShow($id){
        if(!$id){
            \Symfony\Component\Debug\header('页面丢失了',true,404);
        }
        
        $movie = Movie::findOne($id);
        
        $sql = "SELECT md.*,d.name FROM movie_director md LEFT JOIN director d ON d.id="
                . "md.did WHERE md.mid=$id";
        $cmd = \Yii::$app->db->createCommand($sql);
        $directors = $cmd->queryAll();
        
        $sql = "SELECT md.*,d.name FROM movie_actor md LEFT JOIN actor d ON d.id="
                . "md.aid WHERE md.mid=$id";
        $cmd = \Yii::$app->db->createCommand($sql);
        $actors = $cmd->queryAll();
        
        $sql = "SELECT md.*,d.name FROM movie_category md LEFT JOIN category d ON d.id="
                . "md.cid WHERE md.mid=$id";
        $cmd = \Yii::$app->db->createCommand($sql);
        $categories = $cmd->queryAll();

        $urls = MovieBt::findAll(['mid'=>$id]);
        return $this->render('show',[
            'movie'=>$movie,
            'directors' => $directors,
            'actors'=>$actors,
            'categories'=>$categories,
            'tags'=>$this->tags,
            'urls'=>$urls
        ]);
    }
    public function actionDirector(){
        $id = \Yii::$app->request->get('id');
        if(!$id){
            \Symfony\Component\Debug\header('页面丢失了',true,404);
        }
        $director = Director::findOne($id);
        $this->breadcrumbs[]=['label'=>$director->name];
        $page = \Yii::$app->request->get('page',1);
        $rows = \Yii::$app->request->get('rows',20);
        $limit = "LIMIT ".($page-1)*$rows.",$rows";
        $sql = "SELECT md.*,m.* FROM movie_director md LEFT JOIN movie m ON "
                . "md.mid=m.id WHERE md.did=$id $limit";
        $cmd = \Yii::$app->db->createCommand($sql);
        $movies = $cmd->queryAll();
        return $this->render('list',[
            'movies'=>$movies,
	        'breadcrumbs'=>$this->breadcrumbs,
            'tags'=>$this->tags
        ]);
    }
    
    public function actionActor(){
        $id = \Yii::$app->request->get('id');
        if(!$id){
            \Symfony\Component\Debug\header('页面丢失了',true,404);
        }
        $actor = Actor::findOne($id);
        $this->breadcrumbs[]=['label'=>$actor->name];
        $page = \Yii::$app->request->get('page',1);
        $rows = \Yii::$app->request->get('rows',20);
        $limit = "LIMIT ".($page-1)*$rows.",$rows";
        $sql = "SELECT ma.*,m.* FROM movie_actor ma LEFT JOIN movie m ON "
                . "ma.mid=m.id WHERE ma.aid=$id $limit";
        $cmd = \Yii::$app->db->createCommand($sql);
        $movies = $cmd->queryAll();
        return $this->render('list',[
            'movies'=>$movies,
	        'breadcrumbs'=>$this->breadcrumbs,
            'tags'=>$this->tags
        ]);
    }
    
    public function actionCategory(){
        $id = \Yii::$app->request->get('id');
        if(!$id){
            \Symfony\Component\Debug\header('页面丢失了',true,404);
        }
        $cate = Category::findOne($id);
        $this->breadcrumbs[]=['label'=>$cate->name];
        $page = \Yii::$app->request->get('page',1);
        $rows = \Yii::$app->request->get('rows',20);
        $limit = "LIMIT ".($page-1)*$rows.",$rows";
        $sql = "SELECT mc.*,m.* FROM movie_category mc LEFT JOIN movie m ON "
                . "mc.mid=m.id WHERE mc.cid=$id $limit";
        $cmd = \Yii::$app->db->createCommand($sql);
        $movies = $cmd->queryAll();
        return $this->render('list',[
	        'breadcrumbs'=>$this->breadcrumbs,
            'movies'=>$movies,
            'tags'=>$this->tags
        ]);
    }
}
