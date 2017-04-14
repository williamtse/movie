<?php

use yii\db\Migration;
use common\models\Admin;

class m170409_032636_admin_init extends Migration
{
    public function up()
    {
        $admin = new Admin();
        $admin->username = 'admin';
        $admin->setPassword('123456');
        $admin->email = 'admin@admin.com';
        $admin->generateAuthKey();
        if(!$admin->save()){
            var_dump($admin->errors);
            throw new Exception("error accourd");
        }
    }

    public function down()
    {
        echo "m170409_032636_admin_init cannot be reverted.\n";

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
