<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Nombre',
                'attribute' => 'first_name',
            ],
            [
                'label' => 'Apellido',
                'attribute' => 'last_name',
            ],
            [
                'label' => 'Usuario',
                'attribute' => 'username',
            ],
            [
                'label' => 'Rol',
                'attribute' => 'user_level',
            ],
            //'email:email',
            //'password',
            //'authKey',
            //'password_reset_token',
            //'user_level',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
