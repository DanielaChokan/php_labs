<?php

declare(strict_types=1);

use app\models\SignupForm;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Реєстрація';
?>
<div class="auth-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Створіть обліковий запис, заповнивши всі поля.</p>

    <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'autocomplete' => 'username']) ?>
        <?= $form->field($model, 'email')->input('email', ['autocomplete' => 'email']) ?>
        <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'new-password']) ?>
        <?= $form->field($model, 'confirmPassword')->passwordInput(['autocomplete' => 'new-password']) ?>
        <?= Html::submitButton('Зареєструватися', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    <?php ActiveForm::end(); ?>

    <p class="mt-3">
        Уже зареєстровані?
        <?= Html::a('Увійти', ['auth/login']) ?>
    </p>
</div>