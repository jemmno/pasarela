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
 * @property string $gps
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
            [['imei'], 'string', 'max' => 15],
            [['descripcion'], 'string'],
            [['patente'], 'string', 'max' => 12],
            [['gps'], 'string', 'max' => 12],
            [['id_satelital'], 'string', 'max' => 16],

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
            'descripcion' => 'Descripción',
            'gps' => 'Modelo GPS',
            'id_satelital' => 'Id Satelital'
        ];
    }
}
