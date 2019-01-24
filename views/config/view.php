<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Configs */

?>
<div class="configs-view">


    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Puerto de escucha',
                'attribute' => 'port_listen',
            ],
            [
                'label' => 'IP de escucha',
                'attribute' => 'ip_listen',
            ],
            [
                'label' => 'IP de reenvio trama original',
                'attribute' => 'local_ip_forward',
            ],
            [
                'label' => 'Puerto de reenvio trama original',
                'attribute' => 'local_port_forward',
            ],
            [
                'label' => 'IP de reenvio para trama modificada',
                'attribute' => 'ip_forward',
            ],
            [
                'label' => 'Puerto de reenvio para trama modificada',
                'attribute' => 'port_forward',
            ],
            [
                'label' => 'ID credencial para consultar posición skywave',
                'attribute' => 'access_id',
            ],
            [
                'label' => 'PASSWORD credencial para consultar posición skywave',
                'attribute' => 'password',
            ],
            [
                'label' => 'Diferencia horaria a restar en trama modificada ',
                'attribute' => 'dif_horaria',
            ],
        ],
    ]) ?>

</div>
