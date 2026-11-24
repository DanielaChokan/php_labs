<?php

use yii\db\Migration;

class m260000_000002_add_review_author_and_moderation extends Migration
{
    public function safeUp()
    {
        $schema = $this->db->getTableSchema('{{%reviews}}', true);
        if ($schema !== null && !isset($schema->columns['author_name'])) {
            $this->addColumn('{{%reviews}}', 'author_name', $this->string(50)->null());
        }
        if ($schema !== null && !isset($schema->columns['moderation_status'])) {
            $this->addColumn(
                '{{%reviews}}',
                'moderation_status',
                $this->string(50)->defaultValue('preliminary_check_passed')
            );
        }
    }

    public function safeDown()
    {
        $schema = $this->db->getTableSchema('{{%reviews}}', true);
        if ($schema !== null && isset($schema->columns['moderation_status'])) {
            $this->dropColumn('{{%reviews}}', 'moderation_status');
        }
        if ($schema !== null && isset($schema->columns['author_name'])) {
            $this->dropColumn('{{%reviews}}', 'author_name');
        }
    }
}
