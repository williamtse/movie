<?php

use yii\db\Migration;

class m170415_084600_add_avatar_actor extends Migration
{
    public function up()
    {
        $this->dropColumn("movie_actor","avatar");
        $this->addColumn("actor","avatar",$this->string()->comment("演员头像"));
    }

    public function down()
    {
        echo "m170415_084600_add_avatar_actor cannot be reverted.\n";

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
