<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "movie_bt".
 *
 * @property integer $id
 * @property integer $mid
 * @property string $bt
 * @property integer $created_at
 * @property string $title
 * @property string $fmt
 *
 * @property Movie $m
 */
class MovieBt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movie_bt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'created_at'], 'integer'],
            [['bt', 'title', 'fmt'], 'required'],
            [['bt'], 'string'],
            [['title', 'fmt'], 'string', 'max' => 255],
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
            'bt' => 'Bt',
            'created_at' => 'Created At',
            'title' => 'Title',
            'fmt' => 'Fmt',
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
