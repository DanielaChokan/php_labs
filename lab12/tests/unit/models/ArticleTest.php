<?php

declare(strict_types=1);

namespace tests\unit\models;

use app\models\Article;
use PHPUnit\Framework\TestCase;
use yii\web\UploadedFile;

class ArticleTest extends TestCase
{
    public function testRequiredFieldsDateAndContentPurification(): void
    {
        $article = new Article([
            'title' => '  Тестова стаття  ',
            'content' => '<p>Безпечний текст</p><script>alert(1)</script>',
            'published_at' => '2026-11-24',
        ]);

        $this->assertTrue($article->validate(), json_encode($article->getErrors(), JSON_UNESCAPED_UNICODE));
        $this->assertSame('Тестова стаття', $article->title);
        $this->assertStringNotContainsString('<script>', $article->content);

        $missingFields = new Article([
            'title' => '',
            'content' => '',
            'published_at' => '',
        ]);
        $this->assertFalse($missingFields->validate());
        $this->assertArrayHasKey('title', $missingFields->getErrors());
        $this->assertArrayHasKey('content', $missingFields->getErrors());
        $this->assertArrayHasKey('published_at', $missingFields->getErrors());

        $blankTitle = new Article([
            'title' => '   ',
            'content' => 'Текст статті',
            'published_at' => '2026-11-24',
        ]);
        $this->assertFalse($blankTitle->validate());
        $this->assertArrayHasKey('title', $blankTitle->getErrors());

        $invalidDate = new Article([
            'title' => 'Коректна назва',
            'content' => 'Достатній текст',
            'published_at' => '24-11-2026',
        ]);
        $this->assertFalse($invalidDate->validate());
        $this->assertArrayHasKey('published_at', $invalidDate->getErrors());

        $impossibleDate = new Article([
            'title' => 'Коректна назва',
            'content' => 'Достатній текст',
            'published_at' => '2026-02-31',
        ]);
        $this->assertFalse($impossibleDate->validate());
        $this->assertArrayHasKey('published_at', $impossibleDate->getErrors());
    }

    public function testImageFileExtensionAndSizeAreValidated(): void
    {
        $unsupportedFile = new Article();
        $unsupportedFile->imageFile = new UploadedFile([
            'name' => 'script.php',
            'tempName' => __FILE__,
            'type' => 'text/plain',
            'size' => filesize(__FILE__),
            'error' => UPLOAD_ERR_OK,
        ]);
        $this->assertFalse($unsupportedFile->validate(['imageFile']));
        $this->assertArrayHasKey('imageFile', $unsupportedFile->getErrors());

        $oversizedFile = new Article();
        $oversizedFile->imageFile = new UploadedFile([
            'name' => 'large.png',
            'tempName' => __FILE__,
            'type' => 'image/png',
            'size' => 5 * 1024 * 1024 + 1,
            'error' => UPLOAD_ERR_OK,
        ]);
        $this->assertFalse($oversizedFile->validate(['imageFile']));
        $this->assertArrayHasKey('imageFile', $oversizedFile->getErrors());
    }

    public function testArticleCanBeCreatedUpdatedAndDeleted(): void
    {
        $article = new Article([
            'title' => 'CRUD тест',
            'content' => 'Текст для перевірки операцій створення оновлення читання та видалення.',
            'published_at' => '2026-11-24',
            'published' => 1,
        ]);

        $this->assertTrue($article->save(), json_encode($article->getErrors(), JSON_UNESCAPED_UNICODE));
        $id = (int)$article->id;

        $loadedArticle = Article::findOne($id);
        $this->assertNotNull($loadedArticle);
        $this->assertSame('CRUD тест', $loadedArticle->title);

        $loadedArticle->title = 'Оновлена CRUD стаття';
        $loadedArticle->published_at = substr((string)$loadedArticle->published_at, 0, 10);
        $this->assertTrue($loadedArticle->save(), json_encode($loadedArticle->getErrors(), JSON_UNESCAPED_UNICODE));
        $this->assertSame('Оновлена CRUD стаття', Article::findOne($id)->title);

        $this->assertSame(1, $loadedArticle->delete());
        $this->assertNull(Article::findOne($id));
    }
}