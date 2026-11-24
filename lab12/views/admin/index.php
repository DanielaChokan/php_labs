<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Адміністрування статей';
?>

<div class="article-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Створити статтю', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            'published_at:date',
            [
                'attribute' => 'published',
                'format' => 'boolean',
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]) ?>
</div>