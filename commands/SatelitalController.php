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
    
    public function init()
    {
        $this->access = Config::env('ACCESS_ID');
        $this->password = Config::env('PASSWORD');
        \Yii::info('Preguntando desde: ' . date('l jS \of F Y h:i:s A') . "\n", 'poller');
        if (!$this->access || !$this->password) {
            die('Debe setear access_id y password de orbcomm.');
        }

        // conf client
        $this->client = new Client(['baseUrl' => 'http://isatdatapro.skywave.com/GLGW/GWServices_v1/RestMessages.svc']);
    }

    public function actionPreguntar()
    {
        return self::getHoraServer();
    }

    public function getHoraServer()
    {
        $getHoraResponse = $this->client->get('info_utc_time.json', ['access_id' => $this->access, 'password' => $this->password])->send();
        echo $getHoraResponse;
    }

}