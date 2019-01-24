<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label('Nombre') ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label('Apellido') ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true])->label('Teléfono') ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('nombre de usuario') ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Contraseña') ?>

    <?= $form->field($model, 'user_level')->dropDownList([ 'Admin' => 'Admin', 'Normal' => 'Normal', ], ['prompt' => ''])->label('Rol') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
