<?php

function send($trama)
{
    $server_ip = '127.0.0.1';
    $server_port = 43278;
    print PHP_EOL."####################". PHP_EOL;
    print "Sending trama to IP $server_ip, port $server_port". PHP_EOL;

    if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
        socket_sendto($socket, $trama, strlen($trama), 0, $server_ip, $server_port);
        print "Time: " . date("%r") . PHP_EOL;
        \Yii::info('Enviando trama hawk... trama= '. $trama ."\n", 'pasarela');
    } else {
        print("can't create socketn"). PHP_EOL;
        \Yii::info('No se pudo enviar trama hawk... trama= '. $trama ."\n", 'pasarela');
    }
}


function send_local($trama)
{
    $server_ip = '127.0.0.1';
    $server_port = 43279;
    print PHP_EOL."####################". PHP_EOL;
    print "Sending local to IP $server_ip, port $server_port". PHP_EOL;

    if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
        socket_sendto($socket, $trama, strlen($trama), 0, $server_ip, $server_port);
        \Yii::info('Enviando trama local... trama= '. $trama ."\n", 'pasarela');
        print "Time: " . date("%r") . PHP_EOL;
    } else {
        print("can't create socketn"). PHP_EOL;
        \Yii::info('No se pudo enviar trama local... trama= '. $trama ."\n", 'pasarela');
    }
}