<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CommentForm extends Model
{
    public $authorName;
    public $rating;
    public $text;

    public static array $moderationWords = [
        'спам',
        'реклама',
        'казино',
        'шахрай',
        'spam',
        'casino',
    ];

    public function rules(): array
    {
        return [
            [['authorName', 'rating', 'text'], 'required', 'message' => 'Поле «{attribute}» є обов’язковим.'],
            [['authorName', 'text'], 'trim'],
            ['authorName', 'string', 'min' => 2, 'max' => 50,
                'tooShort' => 'Ім’я автора має містити щонайменше 2 символи.',
                'tooLong' => 'Ім’я автора не може перевищувати 50 символів.',
            ],
            ['rating', 'integer', 'min' => 1, 'max' => 5,
                'message' => 'Оцінка має бути цілим числом.',
                'tooSmall' => 'Мінімальна оцінка — 1 зірка.',
                'tooBig' => 'Максимальна оцінка — 5 зірок.',
            ],
            ['text', 'string', 'min' => 10, 'max' => 1000,
                'tooShort' => 'Текст відгуку має містити щонайменше 10 символів.',
                'tooLong' => 'Текст відгуку не може перевищувати 1000 символів.',
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'authorName' => 'Ім’я автора',
            'rating' => 'Оцінка (1–5 зірок)',
            'text' => 'Текст відгуку',
        ];
    }

    public static function getStoragePath(): string
    {
        return Yii::getAlias('@app/data/comments.json');
    }

    public function getRatingCategory(): string
    {
        $numericRating = (int)$this->rating;
        if ($numericRating <= 2) {
            return 'низька';
        }
        if ($numericRating === 3) {
            return 'середня';
        }
        return 'висока';
    }

    public function moderateText(): array
    {
        $foundWords = [];
        foreach (self::$moderationWords as $word) {
            if (mb_stripos((string)$this->text, $word, 0, 'UTF-8') !== false) {
                $foundWords[] = $word;
            }
        }

        if (!empty($foundWords)) {
            return [
                'status' => 'pending_review',
                'message' => 'Відгук потребує додаткової перевірки модератором (виявлено потенційно небажані слова).',
            ];
        }

        return [
            'status' => 'preliminary_check_passed',
            'message' => 'Відгук пройшов попередню автоматизовану перевірку.',
        ];
    }

    public static function loadComments(?string $filePath = null): array
    {
        $path = $filePath ?? self::getStoragePath();

        if (!is_file($path)) {
            return [];
        }

        $raw = file_get_contents($path);
        if ($raw === false || trim($raw) === '') {
            return [];
        }

        $decoded = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded) || !array_is_list($decoded)) {
            return [];
        }

        return $decoded;
    }

    public static function calculateAverageRating(array $comments, int $postId): float
    {
        $ratings = [];
        foreach ($comments as $item) {
            if (isset($item['post_id'], $item['rating']) && (int)$item['post_id'] === $postId) {
                $ratings[] = (int)$item['rating'];
            }
        }

        if (empty($ratings)) {
            return 0.0;
        }

        return round(array_sum($ratings) / count($ratings), 2);
    }

    public static function countForPost(array $comments, int $postId): int
    {
        return count(array_filter(
            $comments,
            static fn (array $comment): bool =>
                isset($comment['post_id']) && (int)$comment['post_id'] === $postId
        ));
    }

    public function saveComment(int $postId = 1, ?string $filePath = null): ?array
    {
        if (!$this->validate()) {
            return null;
        }

        $path = $filePath ?? self::getStoragePath();
        $dir = dirname($path);
        if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
            return null;
        }

        $moderation = $this->moderateText();
        $numericRating = (int)$this->rating;
        $createdAt = date('Y-m-d H:i:s');

        $fp = fopen($path, 'c+');
        if ($fp === false) {
            return null;
        }

        if (!flock($fp, LOCK_EX)) {
            fclose($fp);
            return null;
        }

        $raw = stream_get_contents($fp);
        $comments = [];
        if ($raw !== false && trim($raw) !== '') {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && array_is_list($decoded)) {
                $comments = $decoded;
            }
        }

        $newComment = [
            'id' => uniqid('cmt_', true),
            'post_id' => $postId,
            'author_name' => $this->authorName,
            'text' => $this->text,
            'rating' => $numericRating,
            'moderation_status' => $moderation['status'],
            'created_at' => $createdAt,
        ];

        $comments[] = $newComment;
        $json = json_encode($comments, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        if ($json === false) {
            flock($fp, LOCK_UN);
            fclose($fp);
            return null;
        }

        if (!ftruncate($fp, 0)) {
            flock($fp, LOCK_UN);
            fclose($fp);
            return null;
        }

        rewind($fp);
        $bytesWritten = fwrite($fp, $json);
        if ($bytesWritten === false || $bytesWritten !== strlen($json) || !fflush($fp)) {
            flock($fp, LOCK_UN);
            fclose($fp);
            return null;
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        return [
            'comment' => $newComment,
            'category' => $this->getRatingCategory(),
            'averageRating' => self::calculateAverageRating($comments, $postId),
            'moderationMessage' => $moderation['message'],
        ];
    }
}