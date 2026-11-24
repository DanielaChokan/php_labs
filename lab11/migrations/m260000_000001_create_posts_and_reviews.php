<?php

use yii\db\Migration;

class m260000_000001_create_posts_and_reviews extends Migration
{
    public function safeUp()
    {
        if (!$this->db->getTableSchema('{{%posts}}', true)) {
            $this->createTable('{{%posts}}', [
                'id' => $this->primaryKey(),
                'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
                'user_id' => $this->integer()->defaultValue(1),
                'title' => $this->string(150)->notNull(),
                'content' => $this->text()->notNull(),
                'published' => $this->boolean()->defaultValue(1),
                'published_at' => $this->dateTime()->null(),
                'tags' => $this->json()->null(),
            ]);
        }

        if (!$this->db->getTableSchema('{{%reviews}}', true)) {
            $this->createTable('{{%reviews}}', [
                'id' => $this->primaryKey(),
                'post_id' => $this->integer()->notNull(),
                'author_name' => $this->string(50)->null(),
                'rating' => $this->tinyInteger()->notNull(),
                'comment' => $this->text()->null(),
                'moderation_status' => $this->string(50)->defaultValue('preliminary_check_passed'),
                'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            ]);
        } else {
            $reviewSchema = $this->db->getTableSchema('{{%reviews}}', true);
            if (!isset($reviewSchema->columns['author_name'])) {
                $this->addColumn('{{%reviews}}', 'author_name', $this->string(50)->null());
            }
            if (!isset($reviewSchema->columns['moderation_status'])) {
                $this->addColumn(
                    '{{%reviews}}',
                    'moderation_status',
                    $this->string(50)->defaultValue('preliminary_check_passed')
                );
            }
        }

        $hasPostForeignKey = (bool)$this->db->createCommand(
            'SELECT 1 FROM information_schema.TABLE_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = DATABASE()
               AND TABLE_NAME = :table
               AND CONSTRAINT_TYPE = \'FOREIGN KEY\'',
            [':table' => 'reviews']
        )->queryScalar();

        if (!$hasPostForeignKey) {
            $this->addForeignKey(
                'fk_reviews_post',
                '{{%reviews}}',
                'post_id',
                '{{%posts}}',
                'id',
                'CASCADE'
            );
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{%reviews}}');
        $this->dropTable('{{%posts}}');
    }
}
