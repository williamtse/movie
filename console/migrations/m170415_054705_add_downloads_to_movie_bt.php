<?php

use yii\db\Migration;

class m170415_054705_add_downloads_to_movie_bt extends Migration
{
    public function up()
    {
        $this->addColumn("movie_bt","fmt",$this->string()->notNull()->comment("视频格式"));
    }

    public function down()
    {
        echo "m170415_054705_add_downloads_to_movie_bt cannot be reverted.\n";

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
