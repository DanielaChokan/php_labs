<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Post extends ActiveRecord
{
    public $review_count;
    public $avg_rating;

    public static function tableName()
    {
        return 'posts';
    }

    public function rules()
    {
        return [
            ['title', 'filter', 'filter' => function ($value) {
                $value = trim((string)$value);
                return preg_replace('/\s+/u', ' ', $value);
            }],
            ['content', 'filter', 'filter' => function ($value) {
                return trim((string)$value);
            }],

            [['title', 'content'], 'required', 'message' => 'Поле «{attribute}» є обов’язковим для заповнення.'],

            ['title', 'validateTitleLength'],

            ['content', 'validateWordCount'],

            [['published'], 'boolean'],
            [['published'], 'default', 'value' => 1],
            [['user_id'], 'default', 'value' => 1],
            [['published_at'], 'safe'],
        ];
    }

    public function validateTitleLength($attribute, $params)
    {
        $length = mb_strlen(trim((string)$this->$attribute), 'UTF-8');
        if ($length < 5) {
            $this->addError($attribute, 'Заголовок повинен містити щонайменше 5 символів.');
        } elseif ($length > 150) {
            $this->addError($attribute, 'Заголовок не може перевищувати 150 символів.');
        }
    }

    public function validateWordCount($attribute, $params)
    {
        preg_match_all('/\p{L}+/u', $this->$attribute, $matches);
        $wordCount = count($matches[0]);

        if ($wordCount < 10) {
            $this->addError(
                $attribute,
                "Текст публікації занадто короткий (знайдено слів: {$wordCount}). Доповніть текст щонайменше до 10 слів."
            );
        }
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->title = preg_replace('/\s+/u', ' ', trim((string)$this->title));
        $this->content = trim((string)$this->content);
        $now = date('Y-m-d H:i:s');
        if ($insert) {
            $this->created_at = $now;
        }
        $this->updated_at = $now;

        if ($this->published && empty($this->published_at)) {
            $this->published_at = $now;
        } elseif (!$this->published) {
            $this->published_at = null;
        }

        return true;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок публікації',
            'content' => 'Текст публікації',
            'published' => 'Опублікувати одразу',
            'published_at' => 'Дата публікації',
        ];
    }

    public function getReviews()
    {
        return $this->hasMany(Review::class, ['post_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }
}