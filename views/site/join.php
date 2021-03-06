<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Join';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-join">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create account:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-join']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus'=>true]) ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= Html::submitButton('Register', ['class' => 'btn btn-success', 'name' => 'join-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
