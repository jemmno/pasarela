<?php

namespace app\commands;

use app\models\Vehiculo;
use codemix\yii2confload\Config;
use yii\console\Controller;
use yii\httpclient\Client;

require "utils/parser.php";
require "utils/trama_hawk.php";
require "utils/sendUDP.php";

class SatelitalController extends Controller
{
    public $client= '';
    public $access= '';
    public $password= '';
    public $credenciales = [];
    
    public function init()
    {
        $this->access = Config::env('ACCESS_ID');
        $this->password = Config::env('PASSWORD');
        $this->credenciales = ['access_id' => $this->access, 'password' => $this->password];

        \Yii::info('Preguntando desde: ' . date('l jS \of F Y h:i:s A') . "\n", 'poller');
        
        if (!$this->access || !$this->password) {
            die('Debe setear access_id y password de orbcomm.');
        }

        // conf client
        $this->client = new Client(['baseUrl' => 'http://isatdatapro.skywave.com/GLGW/GWServices_v1/RestMessages.svc']);
    }

    public function actionPreguntar()
    {
        $horaUTC = self::getHoraServer();
        print json_encode(self::getFirstLocationGroup($horaUTC));
    }

    public function getHoraServer()
    {
        $getHoraResponse = $this->client->get('info_utc_time.json', $this->credenciales)->send();
        if ($getHoraResponse->isOk) {
            return $hora = $getHoraResponse->data;
        }
        
    }

    public function getFirstLocationGroup(string $hora)
    {
        $params = [];
        $params = $this->credenciales;
        $params['start_utc'] = $hora;
        $getFirstResponse = $this->client->get('get_return_messages.json', $params)->send();
        if ($getFirstResponse->isOk) {
            return $getFirstResponse->data;
        }
    }

}