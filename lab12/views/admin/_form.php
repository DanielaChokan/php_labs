<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'content')->textarea(['rows' => 10]) ?>
<?= $form->field($model, 'published_at')->input('date') ?>
<?= $form->field($model, 'published')->checkbox() ?>
<?= $form->field($model, 'imageFile')->fileInput(['accept' => '.jpg,.jpeg,.png,.webp']) ?>

<?php if ($model->image_path): ?>
    <p>Поточне зображення:</p>
    <p><?= Html::img('@web/' . $model->image_path, ['alt' => 'Зображення статті', 'style' => 'max-width: 240px;']) ?></p>
<?php endif; ?>

<div class="form-group">
    <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    <?= Html::a('Скасувати', ['index'], ['class' => 'btn btn-secondary']) ?>
</div>

<?php ActiveForm::end(); ?>
