<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Контактна форма';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h2 class="h4 mb-3 text-center fw-bold">Зворотний зв’язок</h2>
                    <p class="text-muted text-center small mb-4">Заповніть поля нижче, щоб надіслати дані</p>

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Наприклад, Олена']) ?>
                        <?= $form->field($model, 'email')->input('email', ['placeholder' => 'name@example.com']) ?>

                        <div class="d-grid mt-4">
                            <?= Html::submitButton('Надіслати', ['class' => 'btn btn-primary btn-lg rounded-3']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>