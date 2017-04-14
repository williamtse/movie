<?php

namespace backend\modules\adminb\controllers;

use backend\modules\adminb\models\AdminProfile;
use common\models\Admin;
use yii\web\Controller;

/**
 * Default controller for the `adminb` module
 */
class DefaultController extends Controller
{
    public $returnUrlParam = 'returnUrl';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        \Yii::$app->getSession()->set($this->returnUrlParam, '/adminb/default/index');
        $profile = AdminProfile::findOne(['adminId'=>\Yii::$app->user->id]);
        return $this->render('index',[
            'profile'=>$profile
        ]);
    }

    public function actionUpdateprofile(){
        $email = \Yii::$app->request->post('email');
        $nick_name = \Yii::$app->request->post("nick_name");
        if($email){
            $admin = Admin::findOne(\Yii::$app->user->id);
            $admin->email = $email;
            $admin->save();
        }
        if($nick_name){
            $profile = AdminProfile::findOne(['adminId'=>\Yii::$app->user->id]);
            if(!$profile){
                $profile = new AdminProfile();
                $profile->adminId = \Yii::$app->user->id;
            }
            $profile->nick_name = $nick_name;
            $profile->save();
        }
        return $this->goBack();
    }

    public function actionPhpinfo(){
        return $this->render('phpinfo');
    }
    public function actionPhpinfoframe(){
        return phpinfo();
    }
}