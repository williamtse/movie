<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MovieBt */

$this->title = '资源分享';
$this->params['breadcrumbs'][] = ['label' => 'Movie Bts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movie-bt-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
