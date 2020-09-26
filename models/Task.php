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
}
