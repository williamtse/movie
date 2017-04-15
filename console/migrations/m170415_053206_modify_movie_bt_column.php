<?php

use yii\db\Migration;

class m170415_053206_modify_movie_bt_column extends Migration
{
    public function up()
    {
        $this->alterColumn("movie_bt","bt",$this->string()->notNull()->comment("下载链接"));
    }

    public function down()
    {
        echo "m170415_053206_modify_movie_bt_column cannot be reverted.\n";

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
