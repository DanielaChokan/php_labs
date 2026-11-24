<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignupForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AuthController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['POST'],
                ],
            ],
        ];
    }

    public function actionLogin(): string|\yii\web\Response
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout(): \yii\web\Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup(): string|\yii\web\Response
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup() !== null) {
            Yii::$app->session->setFlash('success', 'Реєстрація успішна. Тепер увійдіть до системи.');

            return $this->redirect(['auth/login']);
        }

        return $this->render('signup', ['model' => $model]);
    }
}