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
    } else {
        print("can't create socketn"). PHP_EOL;
    }
}
