<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Movie */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Movies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movie-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'year',
            'title',
            'content:ntext',
            'showTime',
            'created_at',
            'updated_at',
            'keywords',
            'poster',
        ],
    ]) ?>
    <h3>下载链接</h3>
    <table class="table">


    <?php
    if($urls){
        foreach($urls as $url){
            ?>
            <tr>
                <td style="word-wrap:break-word"><?=$url->title?></td>
                <td><a href="/movie/movie/delete-bt?id=<?=$url->id?>">删除</a></td>
            </tr>
    <?php
        }
    }
    ?></table>
<p><a class="btn btn-primary" href="/movie/movie/addbt?id=<?=$model->id?>">添加bt下载</a></p>
</div>
