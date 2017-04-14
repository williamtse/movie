<?php

namespace backend\modules\adminb\controllers;

use backend\modules\adminb\models\AdminProfile;
use common\models\Admin;
use yii\web\Controller;
use Yii;
use backend\modules\adminb\models\PasswordResetRequestForm;
use backend\modules\adminb\models\ResetPasswordForm;
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
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect('/adminb/default/reset-password?token='.$model->getPasswordResetToen());
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }
    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}