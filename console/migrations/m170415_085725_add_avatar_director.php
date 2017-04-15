<?php

use yii\db\Migration;

class m170415_085725_add_avatar_director extends Migration
{
    public function up()
    {
        $this->addColumn("director","avatar",$this->string()->comment("导演头像"));
    }

    public function down()
    {
        echo "m170415_085725_add_avatar_director cannot be reverted.\n";

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
