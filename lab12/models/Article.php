<?php

declare(strict_types=1);

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\HtmlPurifier;
use yii\web\UploadedFile;

class Article extends ActiveRecord
{
    public $imageFile;

    public static function tableName(): string
    {
        return '{{%posts}}';
    }

    public function rules(): array
    {
        return [
            ['title', 'filter', 'filter' => 'trim'],
            ['content', 'filter', 'filter' => [HtmlPurifier::class, 'process']],
            [['title', 'content', 'published_at'], 'required'],
            ['title', 'string', 'max' => 150],
            ['content', 'string', 'max' => 65535],
            ['published_at', 'date', 'format' => 'php:Y-m-d', 'strictDateFormat' => true],
            ['published', 'boolean'],
            ['published', 'default', 'value' => 1],
            ['tags', 'safe'],
            [
                'imageFile',
                'file',
                'extensions' => ['png', 'jpg', 'jpeg', 'webp'],
                'checkExtensionByMimeType' => true,
                'maxSize' => 5 * 1024 * 1024,
                'skipOnEmpty' => true,
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'title' => 'Заголовок',
            'content' => 'Текст статті',
            'published_at' => 'Дата',
            'published' => 'Опубліковано',
            'imageFile' => 'Зображення',
            'image_path' => 'Зображення',
        ];
    }

    public function uploadImage(): ?string
    {
        if ($this->imageFile === null) {
            return null;
        }

        $directory = Yii::getAlias('@webroot/uploads');
        FileHelper::createDirectory($directory);

        $fileName = Yii::$app->security->generateRandomString(32)
            . '.' . strtolower($this->imageFile->extension);
        if (!$this->imageFile->saveAs($directory . DIRECTORY_SEPARATOR . $fileName)) {
            throw new \RuntimeException('Не вдалося зберегти завантажене зображення.');
        }

        return 'uploads/' . $fileName;
    }

    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        if ($insert) {
            $this->created_at = $now;
            if (Yii::$app->has('user') && Yii::$app->user->id !== null) {
                $this->user_id = Yii::$app->user->id;
            }
        }
        $this->updated_at = $now;

        return true;
    }
}