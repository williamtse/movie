<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "douban_rating".
 *
 * @property integer $id
 * @property double $average
 * @property integer $stars
 * @property integer $mid
 * @property integer $reviews_count
 * @property integer $wish_count
 * @property integer $comments_count
 * @property integer $ratings_count
 * @property integer $created_at
 * @property integer $updated_at
 */
class DoubanRating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'douban_rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['average', 'stars', 'mid', 'reviews_count', 'wish_count', 'comments_count', 'ratings_count'], 'required'],
            [['average'], 'number'],
            [['stars', 'mid', 'reviews_count', 'wish_count', 'comments_count', 'ratings_count', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'average' => 'Average',
            'stars' => 'Stars',
            'mid' => 'Mid',
            'reviews_count' => 'Reviews Count',
            'wish_count' => 'Wish Count',
            'comments_count' => 'Comments Count',
            'ratings_count' => 'Ratings Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
