<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Configs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="configs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'port_listen')->textInput()->hint('Puerto de escucha') ?>

    <?= $form->field($model, 'ip_listen')->textInput(['maxlength' => true])->hint('Ip de escucha') ?>

    <?= $form->field($model, 'local_ip_forward')->textInput(['maxlength' => true])->hint('Ip reenvio local') ?>

    <?= $form->field($model, 'local_port_forward')->textInput()->hint('Puerto reenvio local') ?>

    <?= $form->field($model, 'ip_forward')->textInput(['maxlength' => true])->hint('Ip para envio trama modificada') ?>

    <?= $form->field($model, 'port_forward')->textInput()->hint('Puerto para envio trama modificada') ?>

    <?= $form->field($model, 'access_id')->textInput(['maxlength' => true])->hint('Credencial webservice orbcomm') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->hint('Credencial webservice orbcomm') ?>

    <?= $form->field($model, 'dif_horaria')->textInput(['maxlength' => true])->hint('Diferencia tiempo recibido de los rastreadores GSM y Cliente trama modificada. Ej: -2') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
