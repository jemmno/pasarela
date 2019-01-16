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
            'port_listen',
            'ip_listen',
            'local_ip_forward',
            'local_port_forward',
            'ip_forward',
            'port_forward',
            'access_id',
            'password',
            'dif_horaria',
        ],
    ]) ?>

</div>
