<?php
/**
 * Created by PhpStorm.
 * User: Xie
 * Date: 2017/4/13
 * Time: 23:25
 */

namespace frontend\controllers;
use common\models\Movie;
use yii\web\Controller;
use Yii;

class MovieController extends Controller
{
    public function actionShow(){
        if(!$id=Yii::$app->request->get('id')){
            \Symfony\Component\Debug\header('页面丢失了',true,404);
        }
        $movie = Movie::findOne($id);

        return $this->render('show',[
            'movie'=>$movie
        ]);
    }
}