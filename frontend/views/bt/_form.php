<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MovieBt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movie-bt-form">

    <?php $form = ActiveForm::begin(); ?>

    <input  type="hidden" id="moviebt-mid" class="form-control" name="MovieBt[mid]" value="<?=Yii::$app->request->get('id')?>">

    <?= $form->field($model, 'bt')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <label>视频格式</label>
        <select class="form-control" name="MovieBt[fmt]">
            <option value="mkv">.mkv</option>
            <option value="rmvb">.rmvb</option>
            <option value="api">.api</option>
            <option value="mp4">.mp4</option>
        </select>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
