<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $text
 * @property int $note_id
 * @property int $priority
 * @property int $status
 *
 * @property Note $note
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'note_id'], 'required'],
            [['note_id', 'priority', 'status'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['note_id'], 'exist', 'skipOnError' => true, 'targetClass' => Note::className(), 'targetAttribute' => ['note_id' => 'id']],
            [['priority'], 'integer', 'min' => -32000, 'max' => 32000],
            ['status', 'in', 'range' => [0, 1]],
            ['priority', 'default', 'value' => 10],
            ['status', 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'note_id' => 'Note ID',
            'priority' => 'Priority',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Note]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNote()
    {
        return $this->hasOne(Note::className(), ['id' => 'note_id']);
    }

    /**
     * Отсортировать задачи по приоритету
     */
    public static function sortByPriority(&$tasks)
    {
        // -1000000000 - используется для того чтобы выполненные задачи оказались в конце массива

        usort($tasks, function ($a, $b) {
            $priority_a = ($a['status'] == 0 ? -1000000000 + $a['priority'] : $a['priority']);
            $priority_b = ($b['status'] == 0 ? -1000000000 + $b['priority'] : $b['priority']);
            return ($priority_a < $priority_b);
        });

    }
}
