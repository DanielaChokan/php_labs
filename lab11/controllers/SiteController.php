<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\CommentForm;
use app\models\EntryForm;
use app\models\Post;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    public function actionEntry(): string
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->render('entry-confirm', ['model' => $model]);
        }

        return $this->render('entry', ['model' => $model]);
    }

    public function actionComment(?int $id = null): string
    {
        $post = $id === null
            ? Post::find()->orderBy(['id' => SORT_ASC])->one()
            : Post::findOne($id);

        if ($post === null) {
            throw new NotFoundHttpException('Публікацію не знайдено.');
        }

        $model = new CommentForm();
        $postId = (int)$post->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result = $model->saveComment($postId);

            if ($result !== null) {
                return $this->render('comment-result', [
                    'post' => $post,
                    'result' => $result,
                    'postId' => $postId,
                ]);
            }

            Yii::$app->session->setFlash('error', 'Не вдалося зберегти відгук у базі даних.');
        }

        $existingComments = CommentForm::loadComments();
        $averageRating = CommentForm::calculateAverageRating($existingComments, $postId);

        return $this->render('comment', [
            'post' => $post,
            'model' => $model,
            'averageRating' => $averageRating,
            'commentsCount' => CommentForm::countForPost($existingComments, $postId),
            'existingComments' => array_values(array_filter(
                $existingComments,
                static fn (array $comment): bool => (int)$comment['post_id'] === $postId
            )),
        ]);
    }
}