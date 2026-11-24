<?php

declare(strict_types=1);

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $login = '';
    public $password = '';
    public $rememberMe = true;

    private ?User $user = null;

    public function rules(): array
    {
        return [
            [['login', 'password'], 'required', 'message' => 'Заповніть це поле.'],
            ['login', 'string', 'min' => 3, 'max' => 254],
            ['password', 'string', 'max' => 72],
            ['password', 'validatePasswordByteLength'],
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean'],
        ];
    }

    public function validatePassword(string $attribute): void
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser();
        if ($user === null || !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Неправильний логін/email або пароль.');
        }
    }

    public function validatePasswordByteLength(string $attribute): void
    {
        if (strlen($this->$attribute) > 72) {
            $this->addError($attribute, 'Пароль не може перевищувати 72 байти.');
        }
    }

    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();
        if ($user === null) {
            return false;
        }

        return Yii::$app->user->login(
            $user,
            $this->rememberMe ? 30 * 24 * 3600 : 0
        );
    }

    private function getUser(): ?User
    {
        if ($this->user === null) {
            $this->user = User::findByUsernameOrEmail(trim($this->login));
        }

        return $this->user;
    }

    public function attributeLabels(): array
    {
        return [
            'login' => 'Логін або email',
            'password' => 'Пароль',
            'rememberMe' => 'Запам’ятати мене',
        ];
    }
}