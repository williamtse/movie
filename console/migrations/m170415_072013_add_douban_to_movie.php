<?php

use yii\db\Migration;

class m170415_072013_add_douban_to_movie extends Migration
{
    public function up()
    {
        $this->addColumn("movie","douban",$this->string()->comment("豆瓣链接"));
    }

    public function down()
    {
        echo "m170415_072013_add_douban_to_movie cannot be reverted.\n";

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
