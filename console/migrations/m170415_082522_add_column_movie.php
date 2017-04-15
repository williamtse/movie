<?php

use yii\db\Migration;

class m170415_082522_add_column_movie extends Migration
{
    public function up()
    {
        $this->addColumn("movie","other_names",$this->text()->comment("其他名称"));

    }

    public function down()
    {
        echo "m170415_082522_add_column_movie cannot be reverted.\n";

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
