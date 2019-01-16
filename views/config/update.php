<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Configs */

$this->title = 'Modificar parametros de configuración';
$this->params['breadcrumbs'][] = 'Configuración';
?>
<div class="configs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
