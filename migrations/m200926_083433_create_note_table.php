<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%note}}`.
 */
class m200926_083433_create_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%note}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'color' => $this->string(6),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-note-user_id',
            'note',
            'user_id',
        );

        $this->addForeignKey(
            'fk-user_id',
            'note',
            'user_id',
            'user',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%note}}');
    }
}
