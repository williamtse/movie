<?php

namespace frontend\controllers;

use backend\modules\movie\Movie;
use common\models\VoteLog;
use Yii;
use common\models\MovieBt;
use common\models\BtSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * BtController implements the CRUD actions for MovieBt model.
 */
class BtController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
//                    [
//                        'actions' => ['signup'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'vote'=>['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all MovieBt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BtSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MovieBt model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MovieBt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new MovieBt();
        $model->created_at=time();
        $model->uid = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

//    /**
//     * Updates an existing MovieBt model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Deletes an existing MovieBt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MovieBt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MovieBt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MovieBt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionVote(){
        if(Yii::$app->user->isGuest){
            return Json::encode(['status'=>2]);
        }
        if(!$tdid=Yii::$app->request->post('tdid')){
            return 0;
        }
        if(!$type=Yii::$app->request->post('type')){
            return 1;
        }
        if(!MovieBt::findOne($tdid)){
            return 2;
        }

        $uid = Yii::$app->user->id;
        $votelog = VoteLog::findOne(['uid'=>$uid,'tdid'=>$tdid]);
        if(!$votelog){
            $votelog = new VoteLog();
            $votelog->uid = $uid;
            $votelog->tdid=$tdid;
            $votelog->type = $type;
            $votelog->created_at = time();
            if($votelog->save()){
                $sql = "SELECT count(1) total FROM vote_log WHERE tdid=$tdid";
                $cmd = Yii::$app->db->createCommand($sql);
                $res = $cmd->queryOne();
                $votes = $res['total'];
                return Json::encode(['status'=>1,'votes'=>$votes]);
            }
        }
        return 4;
    }
}
