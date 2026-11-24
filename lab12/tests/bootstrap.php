<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/vendor/yiisoft/yii2/Yii.php';

Yii::setAlias('@app', dirname(__DIR__));

$config = [
    'id' => 'yii2basic-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => require dirname(__DIR__) . '/config/test_db.php',
    ],
];

new \yii\console\Application($config);
