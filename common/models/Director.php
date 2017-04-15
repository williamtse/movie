<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "director".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property string $avatar
 */
class Director extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'director';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['name', 'avatar'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'avatar' => 'Avatar',
        ];
    }
}
