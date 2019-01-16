<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Vehiculo;
use app\models\Config;
use yii\console\Controller;
use yii\base\ErrorException;
use \Exception;

require "/var/www/pasarela/utils/parser.php";
require "/var/www/pasarela/utils/trama_hawk.php";
require "/var/www/pasarela/utils/sendUDP.php";
// require "utils/parser.php";
// require "utils/trama_hawk.php";
// require "utils/sendUDP.php";


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

        public $local_ip_forward = '';
        public $local_port_forward = '';
        public $port_forward = '';
        public $ip_forward = '';
        public $dif_horaria = '';

     public function actionEscuchar()
    {
        try {
            $conf = Config::find()->one();

            // conf socket
            $port = $conf->port_listen;
            $host = $conf->ip_listen;
            // local
            $this->local_port_forward = $conf->local_port_forward;
            $this->local_ip_forward = $conf->local_ip_forward;
            // externo
            $this->port_forward = $conf->port_forward;
            $this->ip_forward = $conf->ip_forward;
            // dif horaria
            $this->dif_horaria = $conf->dif_horaria;
        } catch (\Throwable $th) {
            die('No se pudo obtener configuración de puerto de escucha! '.$th);
        }
       

        if (!extension_loaded('sockets')) {
            die('The sockets extension is not loaded.');
        }

        // create unix udp socket
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        if (!$socket) {
            onSocketFailure("Failed to create socket", $socket);
        }

        echo "Socket created \n";

        // bind
        if ($socket === false || !socket_bind($socket, $host, $port)) {
            spsocket_close($socket);
            onSocketFailure("Failed to bind socket", $socket);
        } else {
            echo "Socket bind OK \n";
        }

        echo "Listen on $host:$port" . PHP_EOL;
        echo "press Ctrl-C to stop" . PHP_EOL;
        \Yii::info('Arranque: ','ejecucion');

        $buffer = '';

        while (1) {
            echo "\nWaiting for data ... \n";

            try {
                socket_recvfrom($socket, $buffer, 65535, 0, $clientIP, $clientPort);
            } catch (Exception $e) {
                $message .= ": " . socket_strerror(socket_last_error($socket));
                echo "\n Error en el buffer 0" . $message;
                echo "\n Error en el buffer 00" . $e;
                if ($e->getCode() == 4) //  4 == EINTR, interrupted system call (Ctrl+C will interrupt the blocking call as well)
                {
                    \Yii::info('Parada: interrupted system call','ejecucion');
                    usleep(1); //  Don't just continue, otherwise the ticks function won't be processed, and the signal will be ignored, try it!
                    continue; //  Ignore it, if our signal handler caught the interrupt as well, the $running flag will be set to false, so we'll break out
                }
                throw $e; //  It's another exception, don't hide it to the user
            } catch (\Exception $e) {
                $message .= ": " . socket_strerror(socket_last_error($socket));
                echo "\n Error en el buffer I" . $message;
                echo "\n Error en el buffer II" . $e;
            }
            if (strlen($buffer) > 0) //here getting zero legth data
            {
                $address = "$clientIP:$clientPort";
                echo "Received $buffer from remote address $clientIP and remote port $clientPort" . PHP_EOL;
                \Yii::info($buffer . "\n", 'global');
                self::handleDatagram($buffer);
                $buffer = '';
            } else {
                echo "Buffer vacio" . PHP_EOL;
            }

        }

        \Yii::info('Parada ctrl c: ','ejecucion');

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
        try {
            send_local($datagram, $this->local_ip_forward, $this->local_port_forward);
            $tramaHawk = '';
            $imei = self::get_imei($datagram);
            if ($imei != '') {

                list($patente, $gps) = self::findPatente($imei);
                $lat = null;
                $ACC = null;
                $door = null;
                echo "\n modelo gps $gps";
                if (!self::isHeartbeat($datagram)) {
                    switch ($gps) {
                        case '102':
                            list($imei, $lat, $lng, $speed, $UTCDateTime, $direction) = parsear($datagram);
                            break;
                        case '103':
                            //de momento parsear como un coban 102
                            list($imei, $lat, $lng, $speed, $UTCDateTime, $direction) = parsear($datagram);
                            break;
                        case '103b+':
                            list($imei, $lat, $lng, $speed, $UTCDateTime, $direction, $ACC, $door) = parsear103bPlus($datagram);
                            break;
                        default:
                            echo "### no tiene modelo gps" . PHP_EOL;
                    }
                } else {
                    echo "\n Recibio un Heartbeat o formato inadecuado" . PHP_EOL;
                }

                if (is_null($patente) or is_null($lat)) {
                    echo "no se encontro patente del vehiculo" . PHP_EOL;
                } else {
                    echo "patente del vehiculo $patente" . PHP_EOL;
                    $tramaHawk = generarTramaHawk($patente, $lat, $lng, $speed, $UTCDateTime, $direction, $ACC, $door, $this->dif_horaria);
                    \Yii::info('Posición recibida... imei= ' . $imei . ', patente= ' . $patente . ', posición= ' . $lat . ', ' . $lng . "\n", 'pasarela');
                    print_r($tramaHawk);
                    send($tramaHawk,$this->ip_forward,$this->port_forward);
                }
            }
        } catch (\Exception $e) {
            $time = time();
             throw new \Exception("{$time} - {$e}");
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


    public function get_imei($str)
    {
        preg_match_all('/\d{15}/', $str, $matches);
        if (isset($matches[0][0])) {
            echo " #### IMEI via regex" . $matches[0][0];
            return $matches[0][0];
        } else {
            return '';
        }

    }

    //verifica que la trama recibida no sea un Heartbeat
    public function isHeartbeat($datagram)
    {
        
        //12 el 102, 18 comas tiene el 103b+
        $comas = substr_count($datagram, ',');
        return  $comas < 12 ;
    }
}
