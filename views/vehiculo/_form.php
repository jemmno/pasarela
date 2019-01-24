<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Vehiculo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehiculo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'patente')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imei')->textInput()->hint('En caso de ser rastreador skywave, ingrese aqui su id, reemplazando las letras por 9. Ej: 123SKY123 => 123999123') ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?php $var = [ '102' => 'tk102', '103' => 'tk103', '103b+' => 'tk103b+', 'satelital' => 'satelital' ]; ?>

    <?= $form->field($model, 'gps')->dropDownList($var, ['prompt' => 'Seleccione modelo GPS' ]); ?>

    <?= $form->field($model, 'id_satelital')->textInput()->hint('Id en caso de ser rastreador skywave') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
