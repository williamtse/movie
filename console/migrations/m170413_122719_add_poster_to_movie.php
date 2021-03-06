<?php

use yii\db\Migration;

class m170413_122719_add_poster_to_movie extends Migration
{
    public function up()
    {
        $this->addColumn("movie","poster",$this->string()->notNull()->comment("电影海报"));
    }

    public function down()
    {
        echo "m170413_122719_add_poster_to_movie cannot be reverted.\n";

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
