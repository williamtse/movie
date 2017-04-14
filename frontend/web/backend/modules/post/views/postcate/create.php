<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PostCate */

$this->title = 'Create Post Cate';
$this->params['breadcrumbs'][] = ['label' => 'Post Cates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-cate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
