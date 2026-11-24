<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Article;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => static function (): bool {
                            return Yii::$app->user->identity->isAdmin;
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Article::find()->orderBy(['id' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionView(int $id): string
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    public function actionCreate()
    {
        $model = new Article();
        $transaction = null;
        $uploadedPath = null;

        try {
            $transaction = Yii::$app->db->beginTransaction();
            if ($model->load(Yii::$app->request->post())) {
                $model->imageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');
                if (!$model->validate()) {
                    $transaction->rollBack();
                    return $this->render('create', ['model' => $model]);
                }

                if (!$model->save(false)) {
                    throw new \RuntimeException('Не вдалося створити запис статті.');
                }

                $uploadedPath = $model->uploadImage();
                if ($uploadedPath !== null) {
                    $model->image_path = $uploadedPath;
                    if (!$model->save(false, ['image_path'])) {
                        throw new \RuntimeException('Не вдалося зберегти шлях до зображення.');
                    }
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Статтю успішно створено.');
                return $this->redirect(['index']);
            }

            $transaction->rollBack();
        } catch (\Throwable $exception) {
            if ($transaction !== null && $transaction->isActive) {
                $transaction->rollBack();
            }
            $this->removeUploadedFile($uploadedPath);
            Yii::error($exception, __METHOD__);
            $model->addError('title', 'Не вдалося зберегти статтю. Перевірте дані та спробуйте ще раз.');
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $model->published_at = substr((string)$model->published_at, 0, 10);
        $oldImagePath = $model->image_path;
        $transaction = null;
        $uploadedPath = null;

        try {
            $transaction = Yii::$app->db->beginTransaction();
            if ($model->load(Yii::$app->request->post())) {
                $model->imageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');
                if (!$model->validate()) {
                    $transaction->rollBack();
                    return $this->render('update', ['model' => $model]);
                }

                if (!$model->save(false)) {
                    throw new \RuntimeException('Не вдалося оновити запис статті.');
                }

                $uploadedPath = $model->uploadImage();
                if ($uploadedPath !== null) {
                    $model->image_path = $uploadedPath;
                    if (!$model->save(false, ['image_path'])) {
                        throw new \RuntimeException('Не вдалося зберегти шлях до зображення.');
                    }
                }

                $transaction->commit();
                if ($uploadedPath !== null) {
                    $this->removeUploadedFile($oldImagePath);
                }
                Yii::$app->session->setFlash('success', 'Статтю успішно оновлено.');
                return $this->redirect(['view', 'id' => $model->id]);
            }

            $transaction->rollBack();
        } catch (\Throwable $exception) {
            if ($transaction !== null && $transaction->isActive) {
                $transaction->rollBack();
            }
            $this->removeUploadedFile($uploadedPath);
            $model->image_path = $oldImagePath;
            Yii::error($exception, __METHOD__);
            $model->addError('title', 'Не вдалося зберегти статтю. Перевірте дані та спробуйте ще раз.');
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete(int $id)
    {
        $model = $this->findModel($id);
        $imagePath = $model->image_path;
        $transaction = null;

        try {
            $transaction = Yii::$app->db->beginTransaction();
            if ($model->delete() === false) {
                throw new \RuntimeException('Не вдалося видалити запис статті.');
            }
            $transaction->commit();
            $this->removeUploadedFile($imagePath);
            Yii::$app->session->setFlash('success', 'Статтю успішно видалено.');
        } catch (\Throwable $exception) {
            if ($transaction !== null && $transaction->isActive) {
                $transaction->rollBack();
            }
            Yii::error($exception, __METHOD__);
            Yii::$app->session->setFlash('error', 'Не вдалося видалити статтю.');
        }

        return $this->redirect(['index']);
    }

    protected function findModel(int $id): Article
    {
        $model = Article::findOne($id);
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Статтю не знайдено.');
    }

    private function removeUploadedFile(?string $relativePath): void
    {
        if (
            $relativePath === null
            || !preg_match('~^uploads/[A-Za-z0-9_-]+\.(?:jpg|jpeg|png|webp)$~i', $relativePath)
        ) {
            return;
        }

        $path = Yii::getAlias('@webroot/' . $relativePath);
        if (is_file($path) && !unlink($path)) {
            Yii::warning('Не вдалося видалити файл зображення: ' . $relativePath, __METHOD__);
        }
    }
}