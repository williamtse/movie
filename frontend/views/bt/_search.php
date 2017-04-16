<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BtSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movie-bt-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'mid') ?>

    <?= $form->field($model, 'bt') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'fmt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
