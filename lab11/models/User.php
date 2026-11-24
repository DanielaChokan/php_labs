<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_ACTIVE = 10;

    public static function tableName(): string
    {
        return '{{%user}}';
    }

    public static function findIdentity($id): ?self
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        return null;
    }

    public static function findByUsernameOrEmail(string $login): ?self
    {
        return static::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->andWhere(
                'LOWER([[username]]) = LOWER(:login) OR LOWER([[email]]) = LOWER(:login)',
                [':login' => $login]
            )
            ->one();
    }

    public function getId(): int
    {
        return (int)$this->getPrimaryKey();
    }

    public function getAuthKey(): string
    {
        return (string)$this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return hash_equals($this->getAuthKey(), (string)$authKey);
    }

    public function validatePassword(string $password): bool
    {
        return \Yii::$app->security->validatePassword($password, (string)$this->password_hash);
    }

    public function setPassword(string $password): void
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey(): void
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $now = time();
        if ($insert) {
            $this->created_at = $now;
        }
        $this->updated_at = $now;

        return true;
    }
}