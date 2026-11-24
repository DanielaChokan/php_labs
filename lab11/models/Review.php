<?php

namespace app\models;

use yii\db\ActiveRecord;

class Review extends ActiveRecord
{
    public static function tableName()
    {
        return 'reviews';
    }

    public function rules()
    {
        return [
            [['post_id', 'rating'], 'required'],
            [['post_id', 'rating'], 'integer'],
            ['rating', 'in', 'range' => [1, 2, 3, 4, 5]],
            ['comment', 'string'],
            ['author_name', 'string', 'max' => 50],
            [['moderation_status'], 'string', 'max' => 50],
        ];
    }

    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }
}