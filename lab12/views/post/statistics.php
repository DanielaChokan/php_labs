<?php

use yii\helpers\Html;

$this->title = 'Статистика та рейтинг публікацій';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('До списку постів', ['index'], ['class' => 'btn btn-secondary']) ?>
</div>

<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>Місце</th>
            <th>Заголовок публікації</th>
            <th>К-сть відгуків</th>
            <th>Середня оцінка</th>
            <th>Мін / Макс</th>
            <th>Розподіл оцінок (1 ★ — 5 ★)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($stats as $index => $row): ?>
            <?php $hasReviews = (int)$row['review_count'] > 0; ?>
            <tr>
                <td><strong>#<?= $index + 1 ?></strong></td>
                <td><?= Html::encode($row['title']) ?></td>
                <td><?= (int)$row['review_count'] ?></td>
                <td>
                    <?= $hasReviews ? '<strong>' . Html::encode((string)$row['avg_rating']) . '</strong> / 5' : '<span class="text-muted">Немає оцінок</span>' ?>
                </td>
                <td>
                    <?= $hasReviews ? "{$row['min_rating']} / {$row['max_rating']}" : '—' ?>
                </td>
                <td>
                    <?php if ($hasReviews): ?>
                        <table class="table table-sm table-bordered mb-0 text-center" style="font-size: 0.85rem;">
                            <thead>
                                <tr>
                                    <th>1★</th>
                                    <th>2★</th>
                                    <th>3★</th>
                                    <th>4★</th>
                                    <th>5★</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= (int)$row['rate_1'] ?></td>
                                    <td><?= (int)$row['rate_2'] ?></td>
                                    <td><?= (int)$row['rate_3'] ?></td>
                                    <td><?= (int)$row['rate_4'] ?></td>
                                    <td><?= (int)$row['rate_5'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <span class="text-muted">Відгуки відсутні</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>