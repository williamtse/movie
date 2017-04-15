<?php
namespace frontend\components\comment;
use yii\base\Widget;
/**
 * Created by PhpStorm.
 * User: Xie
 * Date: 2017/4/15
 * Time: 12:11
 */
class Comment extends Widget
{
    public $orderBy='created DESC';
    public $limit = 10;
    public $template='<li><a title="{title}" href="#" draggable="false">
            <span class="thumbnail">
            <img class="thumb" data-original="{poster}" 
            src="{poster}" alt="{title}" 
            style="display: block;" draggable="false">
            </span><span class="text">{title}</span>
            <span class="muted">
                                <i class="glyphicon glyphicon-time"></i>
            {time}
            </span><span class="muted"><i class="glyphicon glyphicon-eye-open"></i>{dowloads}</span></a>
        </li>';
    public function run()
    {
        $sql = "SELECT m.* FROM comments c LEFT JOIN movie m ON m.id=c.novel_id GROUP BY m.id "
            .$this->orderBy.' LIMIT '.$this->limit;
        $cmd = \Yii::$app->db->createCommand($sql);
        $movies = $cmd->queryAll();
        $this->renderItems($movies);
    }
    protected function renderItems($movies){
        if($movies){
            foreach($movies as $m){
                echo strtr($this->template,[
                    '{title}'=>$m['title'],
                    '{poster}'=>$m['poster'],
                    '{time}'=>date('Y-m-d',$m['created_at']),
                    '{downloads}'=>$m['downloads'],
                ]);
            }
        }
    }
}