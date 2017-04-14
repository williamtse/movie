<?php

namespace backend\modules\adminb\models;

use Yii;

/**
 * This is the model class for table "admin_profile".
 *
 * @property integer $id
 * @property integer $adminId
 * @property string $nick_name
 * @property integer $updated_at
 * @property integer $created_at
 */
class AdminProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adminId'], 'required'],
            [['adminId', 'updated_at', 'created_at'], 'integer'],
            [['nick_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adminId' => 'Admin ID',
            'nick_name' => 'Nick Name',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
