<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de borrar?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Nombre',
                'attribute' => 'first_name',
            ],
            [
                'label' => 'Apellido',
                'attribute' => 'last_name',
            ],
            [
                'label' => 'Teléfono',
                'attribute' => 'phone_number',
            ],
            [
                'label' => 'Rol',
                'attribute' => 'username',
            ],
            [
                'label' => 'Email',
                'attribute' => 'email',
            ],
            [
                'label' => 'Rol',
                'attribute' => 'user_level',
            ],
        ],
    ]) ?>

</div>
