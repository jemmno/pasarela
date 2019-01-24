<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Configs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="configs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'port_listen')->textInput()->label('Puerto de escucha') ?>

    <?= $form->field($model, 'ip_listen')->textInput(['maxlength' => true])->label('Ip de escucha') ?>

    <?= $form->field($model, 'local_ip_forward')->textInput(['maxlength' => true])->label('Ip reenvio trama original') ?>

    <?= $form->field($model, 'local_port_forward')->textInput()->label('Puerto reenvio trama original') ?>

    <?= $form->field($model, 'ip_forward')->textInput(['maxlength' => true])->label('Ip para envio trama modificada') ?>

    <?= $form->field($model, 'port_forward')->textInput()->label('Puerto para envio trama modificada') ?>

    <?= $form->field($model, 'access_id')->textInput(['maxlength' => true])->label('ID Credencial webservice skywave') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('PASSWORD Credencial webservice skywave') ?>

    <?= $form->field($model, 'dif_horaria')->textInput(['maxlength' => true])->label('Diferencia tiempo recibido de los rastreadores GSM y Cliente trama modificada. Ej: -2') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
