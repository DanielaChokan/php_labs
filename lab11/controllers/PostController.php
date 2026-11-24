<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\db\Query;
use app\models\Post;

class PostController extends Controller
{
    public function actionIndex()
    {
        $query = Post::find()
            ->select([
                'posts.*',
                'review_count' => '(SELECT COUNT(*) FROM reviews r WHERE r.post_id = posts.id)',
                'avg_rating' => '(SELECT ROUND(AVG(r.rating), 2) FROM reviews r WHERE r.post_id = posts.id)',
            ]);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $posts = $query->orderBy(['title' => SORT_ASC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }

    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Публікацію успішно збережено!');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionStatistics()
    {
        $stats = (new Query())
            ->select([
                'p.id',
                'p.title',
                'review_count' => 'COUNT(r.id)',
                'avg_rating' => 'ROUND(AVG(r.rating), 2)',
                'min_rating' => 'MIN(r.rating)',
                'max_rating' => 'MAX(r.rating)',
                'rate_1' => 'SUM(CASE WHEN r.rating = 1 THEN 1 ELSE 0 END)',
                'rate_2' => 'SUM(CASE WHEN r.rating = 2 THEN 1 ELSE 0 END)',
                'rate_3' => 'SUM(CASE WHEN r.rating = 3 THEN 1 ELSE 0 END)',
                'rate_4' => 'SUM(CASE WHEN r.rating = 4 THEN 1 ELSE 0 END)',
                'rate_5' => 'SUM(CASE WHEN r.rating = 5 THEN 1 ELSE 0 END)',
            ])
            ->from(['p' => 'posts'])
            ->leftJoin(['r' => 'reviews'], 'r.post_id = p.id')
            ->groupBy(['p.id', 'p.title'])
            ->orderBy([
                'avg_rating' => SORT_DESC,
                'review_count' => SORT_DESC,
            ])
            ->all();

        return $this->render('statistics', [
            'stats' => $stats,
        ]);
    }
}