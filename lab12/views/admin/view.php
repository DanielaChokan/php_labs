<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Адміністрування статей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="article-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Видалити цю статтю?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            'published_at:date',
            'published:boolean',
            [
                'attribute' => 'image_path',
                'format' => 'raw',
                'value' => $model->image_path
                    ? Html::img('@web/' . $model->image_path, ['alt' => 'Зображення статті', 'style' => 'max-width: 320px;'])
                    : '—',
            ],
        ],
    ]) ?>
</div>