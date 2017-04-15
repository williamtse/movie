<?php

use yii\db\Migration;

class m170415_083050_add_column_movie extends Migration
{
    public function up()
    {
        $this->addColumn("movie","type",$this->string(20)->notNull()->defaultValue('movie')->comment("视频类型"));
    }

    public function down()
    {
        echo "m170415_083050_add_column_movie cannot be reverted.\n";

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
