<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Vehiculo;
use codemix\yii2confload\Config;
use yii\console\Controller;

require "utils/parser.php";
require "utils/trama_hawk.php";
require "utils/sendUDP.php";

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 * lsof -ti:port kill -9 port
 */
class PasarelaController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionEscuchar()
    {
        $port = Config::env('PORT_LISTEN', '7778');
        \Yii::info('Escuchando desde: ' . date('l jS \of F Y h:i:s A') . "\n", 'pasarela');
        if (!extension_loaded('sockets')) {
            die('The sockets extension is not loaded.');
        }

        // conf socket
        $host = Config::env('IP_LISTEN', '127.0.0.1');

        // create unix udp socket
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        if (!$socket) {
            onSocketFailure("Failed to create socket", $socket);
        }

        // reuseable port
        socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

        // bind
        if ($socket === false || !socket_bind($socket, $host, $port)) {
            socket_close($socket);
            onSocketFailure("Failed to bind socket", $socket);
        } else {
            echo "escuchando on $host en el port $port" . PHP_EOL;
            echo "press Ctrl-C to stop" . PHP_EOL;
        }

        $buffer = '';

        while (true) {
            try{
                socket_recvfrom($socket, $buffer, 65535, 0, $clientIP, $clientPort);
            } catch (ErrorException $e) {
                echo "Error en el buffer 0".$e;
            } catch (Exception $e) {
                echo "Error en el buffer 1".$e;
            }
            if(strlen($buffer)>0)//here getting zero legth data
            {
                $address = "$clientIP:$clientPort";
                echo "Received $buffer from remote address $clientIP and remote port $clientPort" . PHP_EOL;
                \Yii::info($buffer . "\n", 'global');
                self::handleDatagram($buffer);
                $buffer = '';
            }
            else 
            {
                echo "Buffer vacio" . PHP_EOL;
            }
            
        }

        /**
         * Trigger an exception with the last socket error.
         *
         * @param String
         * @param Socket
         */
        function onSocketFailure(string $message, $socket = null)
        {
            if (is_resource($socket)) {
                $message .= ": " . socket_strerror(socket_last_error($socket));
            }
            die($message);
        }
    }

    public function handleDatagram($datagram)
    {
        $tramaHawk = '';
        $imei = self::get_imei($datagram);
        echo " #### IMEI via regex" . $imei;
        list($patente, $gps) = self::findPatente($imei);
        echo "### GPS " . $gps;
        $lat = null;
        if (!self::isHeartbeat($datagram)) {
            switch ($gps) {
                case 102:
                    list($imei, $lat, $lng, $speed, $UTCDateTime) = parsear($datagram);
                    break;
                case 103:
                    //de momento parsear como un coban 102
                    list($imei, $lat, $lng, $speed, $UTCDateTime) = parsear($datagram);
                    break;
                default:
                    echo "### no tiene modelo gps" . PHP_EOL;
            }
        } else {
            echo "### recibio un Heartbeat" . PHP_EOL;
        }

        //echo "imei del vehiculo $imei". PHP_EOL;
        if (is_null($patente) or is_null($lat)) {
            echo "no se encontro patente del vehiculo" . PHP_EOL;
        } else {
            echo "patente del vehiculo $patente" . PHP_EOL;
            $tramaHawk = generarTramaHawk($patente, $lat, $lng, $speed, $UTCDateTime);
            \Yii::info('Posición recibida... imei= ' . $imei . ', patente= ' . $patente . ', posición= ' . $lat . ', ' . $lng . "\n", 'pasarela');
            print_r($tramaHawk);
            send($tramaHawk);
            send_local($datagram);
        }
    }

    private function findPatente($imeiPosicion = 0)
    {
        $connection = \Yii::$app->db;
        $vehiculo = Vehiculo::findOne(['imei' => $imeiPosicion]);
        if ($vehiculo) {
            return array($vehiculo->patente, $vehiculo->gps);
        } else {
            return null;
        }
    }

    public function actionTest()
    {
        $connection = \Yii::$app->db;
        $vehiculo = Vehiculo::findOne(['imei' => 1234567890]);
        print_r($vehiculo->patente);
    }

    public function get_imei($str)
    {
        preg_match_all('/\d{15}/', $str, $matches);
        return $matches[0][0];
    }
    
    //verifica que la trama recibida no sea un Heartbeat 
    function isHeartbeat($datagram)
    {
        return substr_count($datagram, ',') !== 12; 
    }
}