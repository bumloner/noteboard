<?php

use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\widgets\ActiveForm;

$this->title = 'My Notes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Note', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="container">
        <div class="row">

            <?php if (empty($notes)): ?>
            	<h3>No notes</h3>
            <?php endif; ?>

            <?php foreach($notes as $note): ?>
                <div class="col-sm-3 note">

                    <div class="note_color" style="background: #<?= $note['color'] ?>"></div>
                    <?= Html::a($note['name'], ['note/update', 'id' => $note['id']], ['class' => 'note_name']) ?>

                    <div class="note_tasks">
                        <?php if (count($note['tasks']) === 0): ?>
                            <div class="note_task">No tasks</div>
                        <?php endif; ?>

                        <?php
                            // сортировка задач по приоритету
                            if ($note['tasks']) {
                            	\app\models\Task::sortByPriority($note['tasks']);
                            }
                        ?>

                        <?php foreach($note['tasks'] as $task): ?>
                            <div class="note_task">
                                <?php
                                    $task_class = 'note_task';
                                    // если задача выполнена, то добавляем нужный класс
                                    if ($task['status'] == 0) {
                                        $task_class .= ' note_task_status_done';
                                    }
                                ?>
                                <?= Html::a($task['text'] . ' (priority: ' . $task['priority'] . ')', [
                                        'task/update',
                                        'id' => $task['id']
                                ], ['class' => $task_class]) ?>

                                <p>
                                    <?= Html::a('Edit task', ['task/update', 'id' => $task['id']], ['class' => 'btn btn-primary']) ?>
                                    <?= Html::a('Del task', ['task/delete', 'id' => $task['id']], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <p>
                        <?= Html::a('Add task', ['task/create', 'note_id' => $note['id']], ['class' => 'btn btn-default']) ?>
                        <?= Html::a('Edit note', ['update', 'id' => $note['id']], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Del note', ['delete', 'id' => $note['id']], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

</div>
