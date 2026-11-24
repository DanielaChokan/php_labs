<?php

use yii\db\Migration;

class m260000_000003_create_user_table extends Migration
{
    public function safeUp()
    {
        if ($this->db->getTableSchema('{{%user}}', true) !== null) {
            return;
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->notNull(),
            'email' => $this->string(254)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx-user-username', '{{%user}}', 'username', true);
        $this->createIndex('idx-user-email', '{{%user}}', 'email', true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
