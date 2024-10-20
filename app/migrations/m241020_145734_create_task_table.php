<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m241020_145734_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->null(),
            'title' => $this->string(255)->notNull(),
            'body' => $this->text()->null(),
            'created_at' => $this->integer()->notNull()->defaultValue(time()),
        ]);

        $this->addForeignKey(
            'fk-task-users',
            'task',
            'user_id',
            'users',
            'id'
        );

        $this->batchInsert('task', ['user_id', 'title', 'body', 'created_at'], [
            [1, 'Создать отчет по продажам', 'Нужно подготовить отчет по продажам за последний квартал.', time()],
            [2, 'Обновить сайт компании', 'Необходимо внести правки на главную страницу и обновить информацию о продуктах.', time()],
            [1, 'Подготовить презентацию для клиентов', 'Создать презентацию для встречи с новыми потенциальными клиентами.', time()],
            [3, 'Проанализировать конкурентов', 'Собрать данные о конкурентах и их маркетинговых стратегиях.', time()],
            [2, 'Организовать корпоративное мероприятие', 'Запланировать и провести встречу с сотрудниками на конец месяца.', time()],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-task-users',
            'task'
        );
        $this->dropTable('task');
    }
}
