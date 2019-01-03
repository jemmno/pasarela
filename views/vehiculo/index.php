<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiculoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehiculos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if (Yii::$app->user->identity->user_level == 'Admin') { ?>
        <p>
            <?= Html::a('Create Vehiculo', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'patente',
            'imei',
            'gps',
            'descripcion:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
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
