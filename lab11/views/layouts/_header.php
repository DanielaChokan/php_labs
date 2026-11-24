<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;
$items = [
    [
        'label' => 'Головна',
        'url' => ['/site/index'],
    ],
    [
        'label' => 'Контакти',
        'url' => ['/site/entry'],
    ],
    [
        'label' => 'Блог',
        'url' => ['/site/comment'],
    ],
];

if (Yii::$app->user->isGuest) {
    $items[] = [
        'label' => 'Вхід',
        'url' => ['/auth/login'],
    ];
    $items[] = [
        'label' => 'Реєстрація',
        'url' => ['/auth/signup'],
    ];
} else {
    $items[] = [
        'label' => 'Вийти (' . Html::encode(Yii::$app->user->identity->username) . ')',
        'url' => ['/auth/logout'],
        'linkOptions' => ['data-method' => 'post'],
    ];
}

?>
<header id="header">
    <?php NavBar::begin(
        [
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
        ],
    ) ?>
    <?= Nav::widget(
        [
            'options' => ['class' => 'navbar-nav me-auto'],
            'encodeLabels' => false,
            'items' => $items,
        ],
    ) ?>
    <?php NavBar::end() ?>
</header>
