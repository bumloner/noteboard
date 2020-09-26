<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m200926_083440_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string()->notNull(),
            'note_id' => $this->integer()->notNull(),
            'priority' => $this->smallInteger()->notNull()->defaultValue(10),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-task-note_id',
            'task',
            'note_id',
        );

        $this->addForeignKey(
            'fk-note_id',
            'task',
            'note_id',
            'note',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
