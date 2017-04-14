<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "movie_director".
 *
 * @property integer $id
 * @property integer $mid
 * @property integer $did
 * @property integer $created_at
 *
 * @property Movie $m
 */
class MovieDirector extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movie_director';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'did', 'created_at'], 'integer'],
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
            'did' => 'Did',
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
