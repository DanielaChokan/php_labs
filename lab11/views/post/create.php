<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Нова публікація';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="post-form mt-4">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Введіть заголовок (5–150 символів)']) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'placeholder' => 'Введіть текст публікації (мінімум 10 слів)']) ?>

    <?= $form->field($model, 'published')->checkbox() ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Зберегти публікацію', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Назад до списку', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>