<?php

namespace tests\unit\models;

use app\models\Post;
use app\models\Review;
use PHPUnit\Framework\TestCase;
use yii\db\Query;

class PostTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Review::deleteAll();
        Post::deleteAll();
    }

    protected function tearDown(): void
    {
        Review::deleteAll();
        Post::deleteAll();
        parent::tearDown();
    }

    public function testTextSanitization()
    {
        $post = new Post();
        $post->title = "   Тестовий    заголовок   із   пробілами   ";
        $post->content = "  Перший абзац тексту який містить достатню кількість слів.\nДругий абзац нового рядка для перевірки збереження форматування.  ";

        $this->assertTrue($post->validate(), 'Валідація має пройти успішно');
        $this->assertEquals('Тестовий заголовок із пробілами', $post->title);
        $this->assertStringContainsString("\n", $post->content);

        $shortContent = new Post();
        $shortContent->title = 'Коректний заголовок статті';
        $shortContent->content = 'Тут лише п’ять українських слів.';
        $this->assertFalse($shortContent->validate());
        $this->assertArrayHasKey('content', $shortContent->getErrors());

        $shortTitle = new Post();
        $shortTitle->title = 'Кіт';
        $shortTitle->content = 'Це достатньо довгий український текст із мінімальною кількістю тестових слів.';
        $this->assertFalse($shortTitle->validate());
        $this->assertArrayHasKey('title', $shortTitle->getErrors());
    }

    public function testSaveAndRetrieveFromDatabase()
    {
        $post = new Post();
        $post->title = 'Публікація з <b>HTML</b> та спецсимволами';
        $post->content = 'Цей текст містить більше десяти слів українською мовою для повної перевірки запису в базу даних.';
        $post->published = 1;

        $this->assertTrue($post->save(), 'Запис повинен зберегтися в БД');

        $savedPost = Post::findOne($post->id);
        $this->assertNotNull($savedPost);
        $this->assertEquals('Публікація з <b>HTML</b> та спецсимволами', $savedPost->title);
        $this->assertNotNull($savedPost->published_at);

        $review = new Review([
            'post_id' => $savedPost->id,
            'rating' => 5,
            'comment' => 'Відгук збережено разом із публікацією',
        ]);
        $this->assertTrue($review->save());
        $this->assertNotNull(Review::findOne($review->id));
    }

    public function testReviewStatisticsAreCalculatedWithSql()
    {
        $post = new Post([
            'title' => 'Статистична публікація',
            'content' => 'Цей український текст містить рівно достатню кількість окремих слів для збереження публікації.',
            'published' => 1,
        ]);
        $this->assertTrue($post->save());

        foreach ([1, 3, 5, 5] as $rating) {
            $review = new Review([
                'post_id' => $post->id,
                'rating' => $rating,
            ]);
            $this->assertTrue($review->save());
        }

        $stats = (new Query())
            ->select([
                'review_count' => 'COUNT(r.id)',
                'avg_rating' => 'ROUND(AVG(r.rating), 2)',
                'min_rating' => 'MIN(r.rating)',
                'max_rating' => 'MAX(r.rating)',
                'rate_1' => 'SUM(CASE WHEN r.rating = 1 THEN 1 ELSE 0 END)',
                'rate_5' => 'SUM(CASE WHEN r.rating = 5 THEN 1 ELSE 0 END)',
            ])
            ->from(['p' => 'posts'])
            ->innerJoin(['r' => 'reviews'], 'r.post_id = p.id')
            ->where(['p.id' => $post->id])
            ->groupBy(['p.id'])
            ->one();

        $this->assertSame(4, (int)$stats['review_count']);
        $this->assertEquals(3.5, (float)$stats['avg_rating']);
        $this->assertSame(1, (int)$stats['min_rating']);
        $this->assertSame(5, (int)$stats['max_rating']);
        $this->assertSame(1, (int)$stats['rate_1']);
        $this->assertSame(2, (int)$stats['rate_5']);
    }
}