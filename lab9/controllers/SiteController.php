<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\CommentForm;
use app\models\EntryForm;
use Yii;
use yii\web\Controller;

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

    public function actionComment(): string
    {
        $postPath = Yii::getAlias('@app/data/post.json');
        $post = [
            'id' => 1,
            'title' => 'Допис блогу',
            'author' => 'Автор',
            'published_at' => date('Y-m-d'),
            'content' => 'Вміст допису тимчасово недоступний.',
        ];

        if (file_exists($postPath)) {
            $decodedPost = json_decode((string)file_get_contents($postPath), true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decodedPost)) {
                $post = $decodedPost;
            }
        }

        $model = new CommentForm();
        $postId = (int)($post['id'] ?? 1);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result = $model->saveComment($postId);

            if ($result !== null) {
                return $this->render('comment-result', [
                    'post' => $post,
                    'result' => $result,
                ]);
            }

            Yii::$app->session->setFlash('error', 'Не вдалося зберегти відгук. Перевірте права доступу до каталогу data.');
        }

        $existingComments = CommentForm::loadComments();
        $averageRating = CommentForm::calculateAverageRating($existingComments, $postId);

        return $this->render('comment', [
            'post' => $post,
            'model' => $model,
            'averageRating' => $averageRating,
            'commentsCount' => CommentForm::countForPost($existingComments, $postId),
        ]);
    }
}