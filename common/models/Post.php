<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $data
 * @property integer $cateId
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PostCate $cate
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'cateId'], 'required'],
            [['content', 'data'], 'string'],
            [['cateId', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['cateId'], 'exist', 'skipOnError' => true, 'targetClass' => PostCate::className(), 'targetAttribute' => ['cateId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'data' => 'Data',
            'cateId' => 'Cate ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCate()
    {
        return $this->hasOne(PostCate::className(), ['id' => 'cateId']);
    }
}
