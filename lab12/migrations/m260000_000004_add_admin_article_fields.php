<?php

use yii\db\Migration;

class m260000_000004_add_admin_article_fields extends Migration
{
    public function safeUp(): void
    {
        $postSchema = $this->db->getTableSchema('{{%posts}}', true);
        if ($postSchema === null) {
            throw new RuntimeException('Таблицю posts потрібно створити до застосування цієї міграції.');
        }
        if (!isset($postSchema->columns['image_path'])) {
            $this->addColumn('{{%posts}}', 'image_path', $this->string(255)->null());
        }

        $userSchema = $this->db->getTableSchema('{{%user}}', true);
        if ($userSchema !== null && !isset($userSchema->columns['is_admin'])) {
            $this->addColumn('{{%user}}', 'is_admin', $this->boolean()->notNull()->defaultValue(false));
        }
    }

    public function safeDown(): void
    {
        $postSchema = $this->db->getTableSchema('{{%posts}}', true);
        if ($postSchema !== null && isset($postSchema->columns['image_path'])) {
            $this->dropColumn('{{%posts}}', 'image_path');
        }

        $userSchema = $this->db->getTableSchema('{{%user}}', true);
        if ($userSchema !== null && isset($userSchema->columns['is_admin'])) {
            $this->dropColumn('{{%user}}', 'is_admin');
        }
    }
}
