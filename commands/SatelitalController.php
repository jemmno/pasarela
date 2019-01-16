<?php

namespace app\commands;

use codemix\yii2confload\Config;
use yii\console\Controller;
use yii\httpclient\Client;

require "utils/trama_coban.php";
require "utils/sendUDP.php";

class SatelitalController extends Controller
{
    public $client = '';
    public $access = '';
    public $password = '';
    public $credenciales = [];
    // Delay between two consecutive GetMessages calls
    public $delayInSeconds = 30;
    public $result = '';

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

        $horaUTC = self::getCurrentGatewayTime();
        while (1) {
            $this->result = self::getReturnMessages($horaUTC);
            if ($this->result != null && json_encode($this->result['ErrorID']) == 0) {
                // Extract from-mobile message
                if (json_encode($this->result['Messages']) != null && strlen(json_encode($this->result['Messages'])) > 0) {
                    $this->procesarMessages($this->result['Messages']);
                }

                // Get filter values for next poll. If no message were returned,
                // the 'Next.StartUTC' will not be valid, i.e., and empty string will
                // be returned
                if (!json_encode($this->result['NextStartUTC']) === null) {
                    // note: If you fail to update the StartUTC, your next GetReturnMessages
                    // call will return the same messages you already get
                    $horaUTC = self::getCurrentGatewayTime();
                } else {
                    echo "No new messages received, at: " . date('d-m-Y H:i:s') . "\n";
                }
            } else if ($this->result != null) {
                echo "Error calling GetReturnMessages \n";
            }
            // Wait before polling web service again. If you call one of Get
            // web service methods with a frecuency thah is higher than what is
            // provisioned for your account, you call is rejected.
            sleep($this->delayInSeconds);
        }
    }

    public function getCurrentGatewayTime()
    {
        $getHoraResponse = $this->client->get('info_utc_time.json', $this->credenciales)->send();
        if ($getHoraResponse->isOk) {
            $hora = $getHoraResponse->data;
            echo "hora server: $hora \n";
            return $hora;
        }

    }

    public function getReturnMessages(string $hora)
    {
        $params = [];
        $params = $this->credenciales;
        $params['start_utc'] = $hora;
        //print_r($params);
        $response = $this->client->get('get_return_messages.json', $params)->send();
        if ($response->isOk) {
            echo "mensaje recibido: " . json_encode($response->data) . "\n\n\n\n";
            return $response->data;
        }
    }

    private function procesarMessages($messages)
    {
        // prueba conversion DD a NMEA
        echo "\n coord convertida".convertDD2NMEAFormat('-1525916', '-3453192');

        //echo "Return messages: ";
        $messages = json_decode(json_encode($this->result['Messages']), true);
        print_r($messages);
        $mensaje = new \stdClass(); 
        if (is_array($messages)) {
            foreach ($messages as $message) {
                $mensaje->mobileID = $message['MobileID'];
                $mensaje->messageUTC = $message['MessageUTC'];
                $fields = $message['Payload']['Fields'];
                foreach ($fields as $field) {
                    $filedName = $field['Name'];
                    $mensaje->$filedName = $field['Value'];
                }
            }
            $tramaCoban = generarTramaCoban($mensaje);
            send_local($tramaCoban);
        }
    }

}
