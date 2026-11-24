<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $post->title;
?>

<div class="container py-4">
    <article class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <h1 class="h3 fw-bold mb-2"><?= Html::encode($post->title) ?></h1>
            <p class="text-muted small mb-3">
                Дата: <?= Html::encode($post->published_at) ?> |
                Середня оцінка: <strong><?= Html::encode((string)$averageRating) ?> / 5</strong>
                (відгуків: <?= (int)$commentsCount ?>)
            </p>
            <p class="mb-0"><?= nl2br(Html::encode($post->content)) ?></p>
        </div>
    </article>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <h2 class="h5 fw-bold mb-3">Залишити відгук</h2>

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger">
                    <?= Html::encode(Yii::$app->session->getFlash('error')) ?>
                </div>
            <?php endif; ?>

            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'authorName')->textInput(['maxlength' => 50, 'placeholder' => 'Ваше ім’я']) ?>

                <?= $form->field($model, 'rating')->radioList([
                    1 => '★',
                    2 => '★★',
                    3 => '★★★',
                    4 => '★★★★',
                    5 => '★★★★★',
                ], [
                    'class' => 'rating-stars d-flex gap-2',
                    'item' => static function ($index, $label, $name, $checked, $value) {
                        $id = 'rating-' . $value;
                        return Html::radio($name, $checked, [
                            'value' => $value,
                            'id' => $id,
                            'class' => 'btn-check',
                        ]) . Html::label($label, $id, [
                            'class' => 'btn btn-outline-warning fs-5',
                            'title' => $value . ' зірок',
                        ]);
                    },
                ]) ?>

                <?= $form->field($model, 'text')->textarea(['rows' => 4, 'placeholder' => 'Напишіть ваш відгук (від 10 символів)...']) ?>

                <div class="mt-3">
                    <?= Html::submitButton('Надіслати відгук', ['class' => 'btn btn-primary px-4']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-body p-4">
            <h2 class="h5 fw-bold mb-3">Відгуки</h2>
            <?php if (empty($existingComments)): ?>
                <p class="text-muted mb-0">Для цього допису ще немає відгуків.</p>
            <?php else: ?>
                <?php foreach ($existingComments as $comment): ?>
                    <?php $rating = (int)$comment['rating']; ?>
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong><?= Html::encode($comment['author_name']) ?></strong>
                            <span class="text-warning"><?= str_repeat('★', $rating) ?><?= str_repeat('☆', 5 - $rating) ?></span>
                        </div>
                        <p class="mb-1 mt-2"><?= nl2br(Html::encode($comment['text'])) ?></p>
                        <small class="text-muted"><?= Html::encode($comment['created_at']) ?></small>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>