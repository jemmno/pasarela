<?php

/**
 * formato trama coban 102
 * imei:XXXXXXXXXXXXXXXX,tracker,1206081637,,F,193729.000,A,1249.9238,S,03816.1788,W,0.01,303.36;
 * imei:XXXXXXXXXXXXXXXX, your IMEI
 * tracker, this is position message
 * 1206081637, UTC Date and Time : YYMMDDHHMM
 * , not identified, always saw this one as empty
 * F, F:Fix (GPS is locked and has position) L: Lost (GPS is unlocked)
 * 193729.000, Time : HHMMSS.mmm Probably local time. Have you configured a time-zone ? I haven't and in my case this is also UTC
 * A, not identified, always saw this one as "A"
 * 1249.9238,S, 12° 49.9328' South
 * 03816.1788,W, 003° 16.1788' West
 * 0.01, speed in notch (nautic miles per hours)
 * 303.36; This one is empty on my tracker. May be altitude ? feet or meters ?
 */
function parsear($trama){
    $imei = '';
    list($imei, $tracker, $UTCDateTime, $empty, $statusGPS, $time, $alwaysA, $lat, $latO, $lng, $lngO, $speed, $direction) = explode(",", $trama);
    $imei = explode(':', $imei)[1];
    $direction = substr($direction,0,-1); //elimina el ; al final
    echo "lat $lat lng $lng". PHP_EOL;

    $speed = IsNullOrEmptyString($speed) ? 0 : $speed;
    $direction = IsNullOrEmptyString($direction) ? 0 : $direction;
    
    if (is_numeric($lat) && is_numeric($lng)) {
        $latitude = convertToGoogleMapsFormat($lat, $latO, 'lat');
        $longitude = convertToGoogleMapsFormat($lng, $lngO, 'lng');
    }else{
        //retornar error de no ubicacion
    }
    return array($imei, $latitude, $longitude, $speed, $UTCDateTime, $direction);
}

/**
 * formato trama coban 103b+
 * imei:864180030811405,tracker,190110184525,,F,184520.000,A,2514.6781,S,05742.4114,W,38.11,43.86,,1,0,0.00%,,;
 * imei:XXXXXXXXXXXXXXXX, your IMEI
 * tracker, this is position message
 * 1206081637, UTC Date and Time : YYMMDDHHMM
 * , not identified, always saw this one as empty
 * F, F:Fix (GPS is locked and has position) L: Lost (GPS is unlocked)
 * 193729.000, Time : HHMMSS.mmm Probably local time. Have you configured a time-zone ? I haven't and in my case this is also UTC
 * A, not identified, always saw this one as "A"
 * 1249.9238,S, 12° 49.9328' South
 * 03816.1788,W, 003° 16.1788' West
 * 0.01, speed in notch (nautic miles per hours)
 * 303.36 Direction
 */
function parsear103bPlus($trama){
    $imei = '';
    list($imei, $tracker, $UTCDateTime, $empty, $statusGPS, $time, $alwaysA, $lat, $latO, $lng, $lngO, $speed, $direction) = explode(",", $trama);
    $imei = explode(':', $imei)[1];
    echo "lat $lat lng $lng direccion $direction". PHP_EOL;

    $speed = IsNullOrEmptyString($speed) ? '' : $speed;
    $direction = IsNullOrEmptyString($direction) ? '' : $direction;
    
    if (is_numeric($lat) && is_numeric($lng)) {
        $latitude = convertToGoogleMapsFormat($lat, $latO, 'lat');
        $longitude = convertToGoogleMapsFormat($lng, $lngO, 'lng');
    }else{
        //retornar error de no ubicacion
    }
    return array($imei, $latitude, $longitude, $speed, $UTCDateTime, $direction);
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
    return $coord;
}

// Function for basic field validation (present and neither empty nor only white space
function IsNullOrEmptyString($str){
    return (!isset($str) || trim($str) === '');
}