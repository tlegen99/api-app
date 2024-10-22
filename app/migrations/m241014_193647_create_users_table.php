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
            'first_name' => $this->string(60)->null(),
            'last_name' => $this->string(60)->null(),
            'password_hash' => $this->string()->notNull(),
            'access_token' => $this->string()->notNull()->unique(),
            'email' => $this->string()->null(),
            'phone' => $this->string(60)->null(),
            'created_at' => $this->integer()->notNull()->defaultValue(time()),
        ]);

        $this->createIndex(
            'idx-users-username',
            'users',
            'username'
        );

        $this->batchInsert('users', ['username', 'first_name', 'last_name', 'password_hash', 'access_token', 'email', 'phone', 'created_at'], [
            ['user1', 'Иван', 'Петров', '$2y$13$TLfPOTYo1aTI4Z4NZvsNFOly7xZQ25d0YDQnY3Pcsi/e1UQAHzGtm', 'RMYlX6gHDRxgSwLjKVsATJyL5JobjDeT', 'john@example.com', '1234567890', time()],
            ['user2', 'Алексей', 'Лобов', '$2y$13$yAYLjQNDf.dD4fIhmBntWuDKLdb/wD5mLuvnECmPq1CdBk93w8Qiq', '5GvC8m2PDJhv3wSC0gK5e-mt2HLZkIyh', 'jane@example.com', '0987654321', time()],
            ['user3', 'Настя', 'Шарипова', '$2y$13$MsEwPoGuAudm26SnafeEaeviRQhRAGCckoaV0kU0vM7/KdcRG6t0K', 'Xjtoo4ozSBBAAm3Vw-bMHiw1e7koS9Jt', 'alice@example.com', '1122334455', time()],
        ]);
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
