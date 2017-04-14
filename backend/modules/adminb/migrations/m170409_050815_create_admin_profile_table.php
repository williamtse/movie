<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin_profile`.
 */
class m170409_050815_create_admin_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('admin_profile', [
            'id' => $this->primaryKey(),
            'adminId'=>$this->integer(11)->notNull()->comment("管理员id"),
            'nick_name'=>$this->string()->comment("管理员昵称"),
            'updated_at'=>$this->integer(11),
            'created_at'=>$this->integer(11)
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin_profile');
    }
}
