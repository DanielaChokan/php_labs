<?php
use yii\helpers\Html;

$this->title = 'Результат збереження відгуку';
$comment = $result['comment'];
$rating = (int)$comment['rating'];
$stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
$isPassed = $comment['moderation_status'] === 'preliminary_check_passed';
?>

<div class="container py-4">
    <div class="alert alert-success rounded-3">
        Відгук успішно збережено!
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <h1 class="h4 fw-bold mb-3">Деталі вашого відгуку</h1>

            <dl class="row mb-0">
                <dt class="col-sm-4">Автор</dt>
                <dd class="col-sm-8"><?= Html::encode($comment['author_name']) ?></dd>

                <dt class="col-sm-4">Оцінка</dt>
                <dd class="col-sm-8">
                    <span class="text-warning fs-5"><?= $stars ?></span>
                    (<?= $rating ?> / 5)
                </dd>

                <dt class="col-sm-4">Категорія оцінки</dt>
                <dd class="col-sm-8"><?= Html::encode($result['category']) ?></dd>

                <dt class="col-sm-4">Середня оцінка допису</dt>
                <dd class="col-sm-8"><strong><?= Html::encode((string)$result['averageRating']) ?> / 5</strong></dd>

                <dt class="col-sm-4">Текст відгуку</dt>
                <dd class="col-sm-8"><?= Html::encode($comment['text']) ?></dd>

                <dt class="col-sm-4">Результат попередньої модерації</dt>
                <dd class="col-sm-8">
                    <span class="badge <?= $isPassed ? 'bg-success' : 'bg-warning text-dark' ?>">
                        <?= Html::encode($comment['moderation_status']) ?>
                    </span>
                    <div class="small text-muted mt-1">
                        <?= Html::encode($result['moderationMessage']) ?>
                    </div>
                </dd>

                <dt class="col-sm-4">Дата й час створення</dt>
                <dd class="col-sm-8"><?= Html::encode($comment['created_at']) ?></dd>
            </dl>

            <div class="mt-4">
                <?= Html::a('Повернутися до допису', ['site/comment'], ['class' => 'btn btn-outline-primary']) ?>
            </div>
        </div>
    </div>
</div>