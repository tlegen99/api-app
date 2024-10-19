<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m241014_193647_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string(60)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'access_token' => $this->string()->notNull()->unique(),
            'created_at' => $this->integer()->notNull()->defaultValue(time()),
            'updated_at' => $this->integer()->notNull()->defaultValue(time()),
        ]);

        $this->createIndex(
            'idx-users-username',
            'users',
            'username'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-users-username', 'users');
        $this->dropTable('users');
    }
}
