<?php
use yii\helpers\Html;

$this->title = 'Підтвердження даних';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h2 class="h4 mb-3 text-success fw-bold">Дані успішно отримано</h2>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item px-0">
                            <strong>Ім’я:</strong> <?= Html::encode($model->name) ?>
                        </li>
                        <li class="list-group-item px-0">
                            <strong>Електронна пошта:</strong> <?= Html::encode($model->email) ?>
                        </li>
                    </ul>
                    <?= Html::a('Повернутися до форми', ['site/entry'], ['class' => 'btn btn-outline-dark']) ?>
                </div>
            </div>
        </div>
    </div>
</div>