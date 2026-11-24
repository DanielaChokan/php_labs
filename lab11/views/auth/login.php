<?php

declare(strict_types=1);

use app\models\LoginForm;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Вхід';
?>
<div class="auth-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Введіть логін або адресу електронної пошти та пароль.</p>

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($model, 'login')->textInput(['autofocus' => true, 'autocomplete' => 'username']) ?>
        <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'current-password']) ?>
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
        <?= Html::submitButton('Увійти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    <?php ActiveForm::end(); ?>

    <p class="mt-3">
        Ще не маєте облікового запису?
        <?= Html::a('Зареєструватися', ['auth/signup']) ?>
    </p>
</div>
