<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Movie */
/* @var $form yii\widgets\ActiveForm */
?>
<div>
    <?php $form = ActiveForm::begin(); ?>
    <h1><?=$movie->name?>-<?=$model->isNewRecord ? '创建' : '更新'?>下载链接</h1>
    <?=$form->field($model, 'title')->textInput()?>
    <?=$form->field($model, 'bt')->textarea()?>
    <?= $form->field($model, 'fmt')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
