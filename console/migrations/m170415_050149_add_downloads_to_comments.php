<?php

use yii\db\Migration;

class m170415_050149_add_downloads_to_comments extends Migration
{
    public function up()
    {
        $this->addColumn("movie","downloads",$this->integer(11)->notNull()->defaultValue(0)
            ->comment("下载次数"));
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable("download_log",[
            'id'=>$this->primaryKey(),
            'ip'=>$this->string(20)->notNull()->comment("下载者ip地址"),
            'created_at'=>$this->integer(11)->comment("下载时间"),
            'mid'=>$this->integer(11)->notNull()->comment("下载电影id")
        ],$tableOptions);
    }

    public function down()
    {
        echo "m170415_050149_add_downloads_to_comments cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
