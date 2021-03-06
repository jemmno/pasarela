<?php
use codemix\yii2confload\Config;

function send($trama, $server_ip, $server_port)
{
    print PHP_EOL."#################### envio hawk". PHP_EOL;
    
    if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
        socket_sendto($socket, $trama, strlen($trama), 0, $server_ip, $server_port);
        \Yii::info('trama hawk a enviar: '. $trama ."\n", 'pasarela');
        \Yii::info('Enviando trama hawk a IP: ' . $server_ip . ', PUERTO: ' . $server_port , 'pasarela');
    } else {
        print("can't create socketn"). PHP_EOL;
        \Yii::info('No se pudo enviar trama hawk... trama= '. $trama ."\n", 'pasarela');
    }
}


function send_local($trama, $server_ip, $server_port, $origen)
{
    print PHP_EOL."#################### envio local". PHP_EOL;
    
    if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
        socket_sendto($socket, $trama, strlen($trama), 0, $server_ip, $server_port);
        \Yii::info('trama local a enviar: '. $trama ."\n", $origen);
        \Yii::info('Enviando trama local a IP: ' . $server_ip . ', PUERTO: ' . $server_port, $origen);
    } else {
        print("can't create socketn"). PHP_EOL;
        \Yii::info('No se pudo enviar trama local... trama= '. $trama ."\n", $origen);
    }
}