<?php

use yii\db\Migration;

class m170414_161651_add_abstract_to_movie extends Migration
{
    public function up()
    {
	$this->addColumn("movie","abstract",$this->string()->comment("摘要"));
    }

    public function down()
    {
        echo "m170414_161651_add_abstract_to_movie cannot be reverted.\n";

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
