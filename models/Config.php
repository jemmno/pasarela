<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "configs".
 *
 * @property int $id
 * @property int $port_listen
 * @property string $ip_listen
 * @property string $local_ip_forward
 * @property int $local_port_forward
 * @property string $ip_forward
 * @property int $port_forward
 * @property string $access_id
 * @property string $password
 * @property string $dif_horaria
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'configs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['port_listen', 'local_port_forward', 'port_forward'], 'integer'],
            [['ip_listen', 'local_ip_forward', 'ip_forward'], 'string', 'max' => 16],
            [['access_id', 'password'], 'string', 'max' => 12],
            [['dif_horaria'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'port_listen' => 'Port Listen',
            'ip_listen' => 'Ip Listen',
            'local_ip_forward' => 'Local Ip Forward',
            'local_port_forward' => 'Local Port Forward',
            'ip_forward' => 'Ip Forward',
            'port_forward' => 'Port Forward',
            'access_id' => 'Access ID',
            'password' => 'Password',
            'dif_horaria' => 'Dif Horaria',
        ];
    }
}
