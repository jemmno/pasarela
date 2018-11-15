<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Vehiculo;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PasarelaController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionEscuchar($port = '7777')
    {
        if (!extension_loaded('sockets')) {
            die('The sockets extension is not loaded.');
        }
        
        // conf socket
        $host = '0.0.0.0';
        
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
        }
        
        $clients = [];
        while (true) {
            socket_recvfrom($socket, $buffer, 65535, 0, $clientIP,$clientPort);
            $address = "$clientIP:$clientPort";
            //if (!isset($clients[$address])) {
            //    $clients[$address] = new Client();
            //}
        
            //$clients[$address]->handlePacket($buffer);
            echo "Received $buffer from remote address $clientIP and remote port $clientPort" . PHP_EOL;
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

    private function findPatente($imeiPosicion=0) {
        $connection = \Yii::$app->db;
        $vehiculo = Vehiculo::findOne(['imei' => $imeiPosicion]);		
        print_r($vehiculo->patente);
        echo '<pre>';
            var_dump($vehiculo->patente);
        echo '</pre>';

        return 0;
    }

    public function actionTest(){

		$connection = \Yii::$app->db;

		//print_R($connection);


		$vehiculo = Vehiculo::findOne(['imei' => 1234567890]);		

		print_r($vehiculo->patente);

	}
}
