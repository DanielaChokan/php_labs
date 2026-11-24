<?php

declare(strict_types=1);

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username = '';
    public $email = '';
    public $password = '';
    public $confirmPassword = '';

    public function rules(): array
    {
        return [
            [['username', 'email'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['username', 'email', 'password', 'confirmPassword'], 'required', 'message' => 'Заповніть це поле.'],
            ['username', 'string', 'min' => 3, 'max' => 50],
            [
                'username',
                'match',
                'pattern' => '/^[\p{L}\p{N}_.-]+$/u',
                'message' => 'Використовуйте лише літери, цифри, крапку, дефіс або підкреслення.',
            ],
            [
                'username',
                'unique',
                'targetClass' => User::class,
                'message' => 'Цей логін уже зайнятий.',
            ],
            [
                'email',
                'filter',
                'filter' => static fn (string $value): string => mb_strtolower($value, 'UTF-8'),
                'skipOnArray' => true,
            ],
            ['email', 'string', 'max' => 254],
            ['email', 'email', 'message' => 'Введіть коректну адресу електронної пошти.'],
            [
                'email',
                'unique',
                'targetClass' => User::class,
                'message' => 'Користувач із такою адресою email уже зареєстрований.',
            ],
            ['password', 'string', 'min' => 8, 'max' => 72],
            ['password', 'validatePasswordByteLength'],
            ['confirmPassword', 'string', 'max' => 72],
            [
                'confirmPassword',
                'compare',
                'compareAttribute' => 'password',
                'message' => 'Паролі не збігаються.',
            ],
        ];
    }

    public function signup(): ?User
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if (!$user->save(false)) {
            $this->addError('username', 'Не вдалося створити обліковий запис. Повторіть спробу.');
            return null;
        }

        return $user;
    }

    public function validatePasswordByteLength(string $attribute): void
    {
        if (strlen($this->$attribute) > 72) {
            $this->addError($attribute, 'Пароль не може перевищувати 72 байти.');
        }
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Логін',
            'email' => 'Електронна пошта',
            'password' => 'Пароль',
            'confirmPassword' => 'Підтвердження пароля',
        ];
    }
}