<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Пости';
$this->registerCssFile('@web/css/post.css');
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Пости</h1>
    <div>
        <?= Html::a('Створити публікацію', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Статистика відгуків', ['statistics'], ['class' => 'btn btn-outline-primary']) ?>
    </div>
</div>

<?php foreach ($posts as $post): ?>
    <div class="post-card">
        <h2 class="post-title"><?= Html::encode($post->title) ?></h2>
        <p class="post-text"><?= nl2br(Html::encode($post->content)) ?></p>
        <div class="mt-2">
            <?= Html::a('Переглянути й прокоментувати', ['site/comment', 'id' => $post->id], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <?php if ($post->published): ?>
                <p class="post-date">Дата публікації: <?= Html::encode($post->published_at) ?></p>
            <?php else: ?>
                <p class="post-date text-warning">Статус: Чернетка</p>
            <?php endif; ?>

            <span class="badge bg-secondary">
                Відгуків: <?= (int)$post->review_count ?>
                <?php if ($post->avg_rating !== null): ?>
                    &nbsp; Середня оцінка: <?= Html::encode($post->avg_rating) ?> / 5
                <?php else: ?>
                    &nbsp; Середня оцінка: немає
                <?php endif; ?>
            </span>
        </div>
    </div>
<?php endforeach; ?>

<?= LinkPager::widget([
    'pagination' => $pagination,
    'options' => ['class' => 'pagination'],
    'linkContainerOptions' => ['class' => 'page-item'],
    'linkOptions' => ['class' => 'page-link'],
]) ?>