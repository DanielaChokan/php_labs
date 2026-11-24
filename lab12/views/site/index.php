<?php

use yii\helpers\Html;

$this->title = 'Мій Yii2 проєкт';
?>
<section class="home-hero rounded-4 p-4 p-md-5 mb-4">
    <div class="row align-items-center g-4">
        <div class="col-12 text-center">
            <h1 class="home-title display-5 fw-bold mb-4"><?= Html::encode($this->title) ?></h1>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <?= Html::a('Написати нам', ['site/entry'], ['class' => 'btn btn-dark btn-lg']) ?>
                <?= Html::a('Перейти до блогу', ['site/comment'], ['class' => 'btn btn-outline-dark btn-lg']) ?>
            </div>
        </div>
    </div>
</section>
