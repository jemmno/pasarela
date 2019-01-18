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

 //require "parser.php";

function generarTramaCoban($mensaje)
{
    // $fecha = formatFecha($UTCDateTime);
    // $velocidad = millasNauticasAKmH($speed);
    $imei = $mensaje->imei;
    $lat = $mensaje->latitude;
    $lng = $mensaje->longitude;
    $velocidad = $mensaje->speed;
    $fecha = $mensaje->messageUTC;
    $orientacion = $mensaje->heading;
    $latlng = convertDD2NMEAFormat($lat,$lng);
    return $trama = "imei:$imei,tracker,$fecha,,F,,$latlng,$velocidad,$orientacion";
}

function convertDD2NMEAFormat($lat, $lng){
    $nmea = $nmelat = $nmealng = "";
    $lata = abs((float)$lat/60000); //le quita el signo
    $latd = intval($lata); //obtiene la parte entera del float
    $latm = ($lata - $latd) * 60;
    $lath = $lat > 0 ? "N" : "S";
    
    $lnga = abs((float)$lng/6000);
    $lngd = intval($lnga);
    $lngm = ($lnga - $lngd) * 60;
    $lngh = $lng > 0 ? "E" : "W";

    $nmelat = str_pad($latd,3,'0',STR_PAD_LEFT).number_format($latm, 5)  . ",". $lath;
    $nmealng = str_pad($lngd,3,'0',STR_PAD_LEFT).number_format($lngm, 5) . "," . $lngh;
    $nmea = $nmelat.','.$nmealng;

    // prueba 
    //convertToGoogleMapsFormat($latd.$latm, $lath, 'lat');
    //convertToGoogleMapsFormat($lngd.$lngm, $lngh, 'lng');

    return $nmea;
}
