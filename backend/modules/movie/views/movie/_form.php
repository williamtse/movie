<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Movie */
/* @var $form yii\widgets\ActiveForm */
?>
<?=Html::cssFile("@web/wangEditor/css/wangEditor.css")?>

<?=Html::jsFile("@web/wangEditor/js/wangEditor.js")?>
<?=Html::jsFile("@web/uploadify/jquery.uploadify.min.js")?>
<?=Html::cssFile("@web/uploadify/uploadify.css")?>
<div class="movie-form">

    <?php $form = ActiveForm::begin(); ?>
    <?=$form->field($model, 'name')->textInput()?>
    <?=$form->field($model, 'poster')->textInput()?>
    <?= $form->field($model, 'year')->textInput(['id'=>'poster']) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'showTime')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
    <div class="form-group field-poster required">
        <label class="control-label" for="poster">分类</label>
        <input type="text" id="poster" class="form-control" name="categories"
               value="<?=$categories?implode('/',$categories):''?>" aria-required="true">
        <div class="help-block"></div>
    </div>
    <div class="form-group field-poster required">
        <label class="control-label" for="poster">导演</label>
        <input type="text" id="poster" class="form-control" name="directors"
               value="<?=$directors?implode('/',$directors):''?>" aria-required="true">
        <div class="help-block"></div>
    </div>
    <div class="form-group field-poster required">
        <label class="control-label" for="poster">演员</label>
        <input type="text" id="poster" class="form-control" name="actors"
               value="<?=$actors?implode('/',$actors):''?>" aria-required="true">
        <div class="help-block"></div>
    </div>
    <?= $form->field($model, 'content')->textarea(['rows' => 6,'id'=>'editor-trigger']) ?>





    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    var editor = new wangEditor('editor-trigger');
    // 上传图片
    editor.config.uploadImgUrl = '/upload';
    editor.config.uploadParams = {
        // token1: 'abcde',
        // token2: '12345'
    };
    editor.create();
</script>