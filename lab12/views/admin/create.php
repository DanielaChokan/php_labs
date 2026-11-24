<?php

use yii\helpers\Html;

$this->title = 'Створення статті';
$this->params['breadcrumbs'][] = ['label' => 'Адміністрування статей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', ['model' => $model]) ?>