<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vote_log`.
 */
class m170416_092457_create_vote_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('vote_log', [
            'id' => $this->primaryKey(),
            'tdid'=>$this->integer(11)->notNull()->comment("资源id"),
            'uid'=>$this->integer(11)->notNull()->comment("投票者id"),
            'type'=>$this->smallInteger(2)->notNull()->comment("1:好，-1：不好"),
            'created_at'=>$this->integer(11)->notNull()->comment("投票时间")
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('vote_log');
    }
}
