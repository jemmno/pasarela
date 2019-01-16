<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'port_listen',
            'ip_listen',
            'local_ip_forward',
            'local_port_forward',
            //'ip_forward',
            //'port_forward',
            //'access_id',
            //'password',
            //'dif_horaria',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update}',
                'visibleButtons'=>[
                    'update'=> function($model){
                        return Yii::$app->user->identity->user_level == 'Admin';
                    },
                    'delete'=> function($model){
                        return Yii::$app->user->identity->user_level == 'Admin';
                    },
                ]
            ],
        ],
    ]); ?>
</div>
