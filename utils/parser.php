<?php

/**
 * formato trama coban 102
 * imei:XXXXXXXXXXXXXXXX,tracker,1206081637,,F,193729.000,A,1249.9238,S,03816.1788,W,0.01,303.36;
 *
 */

function parsear($trama){
    $imei = '';
    $datos = explode(",", $trama);
    list($imei, $tracker, $UTCDateTime, $empty, $statusGPS, $time, $alwaysA, $lat, $latO, $lng, $lngO, $speed) = explode(",", $trama);
    $imei = explode(':', $imei)[1];
    echo "lat $lat lng $lng". PHP_EOL;
    if (is_numeric($lat) && is_numeric($lng)) {
        convertToGoogleMapsFormat($lat, $latO, 'lat');
        convertToGoogleMapsFormat($lng, $lngO, 'lng');
    }else{
        //retornar error de no ubicacion
    }
    return array($imei, $lat, $lng, $speed);
}

/**
 * format is in ddmm.mmmm (lat) and dddmm.mmmm (lng)
 * Take the dd (lat) or ddd (lng) and add it to (mm.mmmm / 60.0).
 * If the lat value is followed by S you have to multiply it with -1. 
 * If the lng value is followed by a W, multiply it with -1.
 * e.g.: lat: 5722.5915 -> 57 + (22.5915 / 60) = 57.376525
 */
function convertToGoogleMapsFormat($coordenada, $orientacion, $tipo){
    $dPart = ($tipo == 'lat') ? substr($coordenada, 0, 2) : substr($coordenada, 0, 3);  
    $mPart = ($tipo == 'lat') ? substr($coordenada, 2, 8) : substr($coordenada, 3, 8);
    $coord = $dPart + ($mPart / 60 );
    $coord = ($orientacion == 'S' || $orientacion == 'W') ? $coord * -1 : $coord;
    echo "dpart $dPart , mPart $mPart, coord: $coord". PHP_EOL;
    //$pos = $dPart + ()
    //return ;
}
?>