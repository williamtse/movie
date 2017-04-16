<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vote_log".
 *
 * @property integer $id
 * @property integer $tdid
 * @property integer $uid
 * @property integer $type
 * @property integer $created_at
 */
class VoteLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tdid', 'uid', 'type', 'created_at'], 'required'],
            [['tdid', 'uid', 'type', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tdid' => 'Tdid',
            'uid' => 'Uid',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }
}
