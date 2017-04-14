<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "movie_actor".
 *
 * @property integer $id
 * @property integer $mid
 * @property integer $aid
 * @property integer $created_at
 *
 * @property Movie $m
 */
class MovieActor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movie_actor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'aid', 'created_at'], 'integer'],
            [['mid'], 'exist', 'skipOnError' => true, 'targetClass' => Movie::className(), 'targetAttribute' => ['mid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mid' => 'Mid',
            'aid' => 'Aid',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getM()
    {
        return $this->hasOne(Movie::className(), ['id' => 'mid']);
    }
}
