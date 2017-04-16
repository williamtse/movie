<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MovieBt */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Movie Bts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movie-bt-view container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'mid',
            'bt:ntext',
            'created_at',
            'title',
            'fmt',
        ],
    ]) ?>

</div>
