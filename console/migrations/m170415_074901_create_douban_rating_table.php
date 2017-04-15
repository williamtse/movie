<?php

use yii\db\Migration;

/**
 * Handles the creation of table `douban_rating`.
 */
class m170415_074901_create_douban_rating_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('douban_rating', [
            'id' => $this->primaryKey(),
            'average'=>$this->float(3)->notNull()->comment("平均分"),
            'stars'=>$this->integer(10)->notNull()->notNull()->comment("星"),
            'mid'=>$this->integer(20)->notNull()->comment("豆瓣电影id"),
            'reviews_count'=>$this->integer(11)->notNull()->comment("看过人数"),
            'wish_count'=>$this->integer(11)->notNull()->comment("想看人数"),
            'comments_count'=>$this->integer(11)->notNull()->comment("评论人数"),
            'ratings_count'=>$this->integer(11)->notNull()->comment("评分人数"),
            'created_at'=>$this->integer(11),
            'updated_at'=>$this->integer(11)
        ],$tableOptions);
        $this->addColumn("movie_actor","avatar",$this->string()->comment("演员头像文件名"));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('douban_rating');
    }
}
