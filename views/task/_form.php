<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */

// заполняем свойства задачи по умолчанию
if (!isset($model->priority)) {
    $model->priority = 10;
}
if (!isset($model->status)) {
    $model->status = 1;
}
?>

<?php if(isset($note_name)): ?>
    <p>Note: <b><?= $note_name ?></b></p>
<?php endif; ?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'priority')->textInput(['value' => $model->priority]) ?>

    <?= $form->field($model, 'status')->checkbox([
            'checked ' => ($model->status === 1 ? true : false)])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
