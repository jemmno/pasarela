<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehiculos".
 *
 * @property int $id
 * @property string $patente
 * @property int $imei
 * @property string $descripcion
 */
class Vehiculo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imei'], 'required'],
            [['imei'], 'integer'],
            [['descripcion'], 'string'],
            [['patente'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'patente' => 'Patente',
            'imei' => 'Imei',
            'descripcion' => 'Descripcion',
        ];
    }
}
