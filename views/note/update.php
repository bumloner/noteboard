<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Note */

$this->title = 'Update Note: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="note-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <div class="note_date">Created: <?= Yii::$app->formatter->asDatetime($model['created_at']) ?></div>
    <div class="note_date">Updated: <?= Yii::$app->formatter->asDatetime($model['updated_at']) ?></div>

</div>
