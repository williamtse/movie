<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PostCate */

$this->title = 'Update Post Cate: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Post Cates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-cate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
