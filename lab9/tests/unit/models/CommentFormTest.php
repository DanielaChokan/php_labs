<?php

namespace tests\unit\models;

use app\models\CommentForm;
use PHPUnit\Framework\TestCase;

class CommentFormTest extends TestCase
{
    private string $tempFile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tempFile = sys_get_temp_dir() . '/test_comments_' . uniqid() . '.json';
    }

    protected function tearDown(): void
    {
        if (file_exists($this->tempFile)) {
            unlink($this->tempFile);
        }
        parent::tearDown();
    }

    public function testValidationRules()
    {
        $empty = new CommentForm();
        $this->assertFalse($empty->validate());
        $this->assertArrayHasKey('authorName', $empty->errors);
        $this->assertArrayHasKey('rating', $empty->errors);
        $this->assertArrayHasKey('text', $empty->errors);

        $invalid = new CommentForm([
            'authorName' => 'А',
            'rating' => 7,
            'text' => 'Коротко',
        ]);
        $this->assertFalse($invalid->validate());

        $valid = new CommentForm([
            'authorName' => 'Олена',
            'rating' => 5,
            'text' => 'Дуже корисна стаття про архітектуру Yii2!',
        ]);
        $this->assertTrue($valid->validate());
    }

    public function testRatingCategoriesAndAverage()
    {
        $low = new CommentForm(['rating' => 2]);
        $this->assertSame('низька', $low->getRatingCategory());

        $mid = new CommentForm(['rating' => 3]);
        $this->assertSame('середня', $mid->getRatingCategory());

        $high = new CommentForm(['rating' => 5]);
        $this->assertSame('висока', $high->getRatingCategory());

        $comments = [
            ['post_id' => 1, 'rating' => 5],
            ['post_id' => 1, 'rating' => 4],
            ['post_id' => 2, 'rating' => 1],
        ];
        $this->assertSame(4.5, CommentForm::calculateAverageRating($comments, 1));
        $this->assertSame(2, CommentForm::countForPost($comments, 1));
    }

    public function testTextModeration()
    {
        $clean = new CommentForm(['text' => 'Чудовий матеріал, усе зрозуміло пояснено.']);
        $this->assertSame('preliminary_check_passed', $clean->moderateText()['status']);

        $flagged = new CommentForm(['text' => 'Це якась РЕКЛАМА невідомого сервісу!']);
        $this->assertSame('pending_review', $flagged->moderateText()['status']);
    }

    public function testJsonSaveLoadAndUkrainianSymbols()
    {
        $model = new CommentForm([
            'authorName' => 'Євгенія Їжаченко',
            'rating' => 5,
            'text' => 'Відгук з українськими літерами: є, ї, і, ґ.',
        ]);

        $result = $model->saveComment(1, $this->tempFile);
        $this->assertNotNull($result);
        $this->assertSame(5.0, $result['averageRating']);

        $rawContent = file_get_contents($this->tempFile);
        $this->assertStringContainsString('Євгенія Їжаченко', $rawContent);

        $loaded = CommentForm::loadComments($this->tempFile);
        $this->assertCount(1, $loaded);
        $this->assertSame('Євгенія Їжаченко', $loaded[0]['author_name']);
    }

    public function testMissingOrCorruptedJson()
    {
        $this->assertSame([], CommentForm::loadComments($this->tempFile . '_nonexistent'));

        file_put_contents($this->tempFile, '{invalid json...');
        $this->assertSame([], CommentForm::loadComments($this->tempFile));
    }
}