<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */

// получаем массив с названиями всех заметок
$notes = \app\models\Note::getAll();
$notes_names = [];
foreach ($notes as $note) {
    $notes_names[$note['id']] = $note['name'];
}

// заполняем свойства задачи по умолчанию
if (!isset($model->priority)) {
    $model->priority = 10;
}
if (!isset($model->status)) {
    $model->status = 1;
}
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note_id')->listBox($notes_names) ?>

    <?= $form->field($model, 'priority')->textInput(['value' => $model->priority]) ?>

    <?= $form->field($model, 'status')->checkbox([
            'checked ' => ($model->status === 1 ? true : false)])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
