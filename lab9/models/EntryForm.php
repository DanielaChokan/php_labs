<?php

namespace app\models;

use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $email;

    public function rules(): array
    {
        return [
            [['name', 'email'], 'required', 'message' => 'Це поле є обов’язковим.'],
            ['email', 'email', 'message' => 'Введіть коректну адресу електронної пошти.'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Ваше ім’я',
            'email' => 'Електронна пошта',
        ];
    }
}