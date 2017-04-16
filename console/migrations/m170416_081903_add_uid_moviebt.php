<?php

use yii\db\Migration;

class m170416_081903_add_uid_moviebt extends Migration
{
    public function up()
    {
        $this->addColumn("movie_bt","uid",$this->integer(11)->notNull()->comment("发布者id"));
    }

    public function down()
    {
        echo "m170416_081903_add_uid_moviebt cannot be reverted.\n";

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
