<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "movie".
 *
 * @property integer $id
 * @property string $name
 * @property integer $year
 * @property string $title
 * @property string $content
 * @property string $showTime
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $keywords
 * @property string $poster
 * @property string $abstract
 *
 * @property MovieActor[] $movieActors
 * @property MovieBt[] $movieBts
 * @property MovieCategory[] $movieCategories
 * @property MovieDirector[] $movieDirectors
 */
class Movie extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movie';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'year', 'title', 'poster'], 'required'],
            [['year', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['name', 'title', 'showTime', 'keywords', 'poster', 'abstract'], 'string', 'max' => 255],
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
            'year' => 'Year',
            'title' => 'Title',
            'content' => 'Content',
            'showTime' => 'Show Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'keywords' => 'Keywords',
            'poster' => 'Poster',
            'abstract' => 'Abstract',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovieActors()
    {
        return $this->hasMany(MovieActor::className(), ['mid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovieBts()
    {
        return $this->hasMany(MovieBt::className(), ['mid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovieCategories()
    {
        return $this->hasMany(MovieCategory::className(), ['mid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovieDirectors()
    {
        return $this->hasMany(MovieDirector::className(), ['mid' => 'id']);
    }
}

