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

 require "parser.php";

function generarTramaCoban($mensaje)
{
    $UTC = new \DateTimeZone("UTC");
    $fecha = new \DateTime( $mensaje->messageUTC , $UTC );
    //$newTZ = new \DateTimeZone("America/Asuncion");
    //$fecha->setTimezone( $newTZ );
    echo $fecha->format(' fecha recibida ymdHis');  
    $fecha_formateada = $fecha->format('ymdHis');
    $hora_formateada = $fecha->format('His.v');
    echo "\n current time para la trama coban $hora_formateada \n";   
    $imei = $mensaje->imei;
    $lat = ($mensaje->latitude)/60000.0;
    $lng = ($mensaje->longitude)/60000.0;
    echo "\n tipo de posicion $mensaje->name \n";   
    // se debe dividir entre 5.4 para pasar a km/h
    // se divide entre 1.852 para pasar de km/h a notch. 
    $velocidad = (($mensaje->speed)/5.4)/1.852; 
    $orientacion = $mensaje->heading*0.1;
    $latlng = convertDD2NMEAFormat($lat,$lng);
    return $trama = "imei:$imei,tracker,$fecha_formateada,,F,$hora_formateada,A,$latlng,$velocidad,$orientacion;";
}

function convertDD2NMEAFormat($lat, $lng){
    $nmea = $nmelat = $nmealng = "";
    $lata = abs((float)$lat); //le quita el signo
    $latd = intval($lata); //obtiene la parte entera del float
    $latm = ($lata - $latd) * 60.0;
    $lath = $lat > 0 ? "N" : "S";
    
    $lnga = abs((float)$lng);
    //echo ("\n $lnga")."    ".($lnga*0.10);
    $lngd = intval($lnga);
    $lngm = ($lnga - $lngd) * 60.0;
    $lngh = $lng > 0 ? "E" : "W";

    $lngd = str_pad($lngd,3,'0',STR_PAD_LEFT);

    if (strlen(intval($latm)) == 1) {
        $nmelat = $latd."0".number_format($latm, 5)  . ",". $lath;
    }else{
        $nmelat = $latd.number_format($latm, 5)  . ",". $lath;
    }
    if (strlen(intval($lngm)) == 1) {
        $nmealng = $lngd."0".number_format($lngm, 5) . "," . $lngh;
    }else{
        $nmealng = $lngd.number_format($lngm, 5) . "," . $lngh;
    }
    $nmea = $nmelat.','.$nmealng;

    // prueba 
    // convertToGoogleMapsFormat($latd.$latm, $lath, 'lat');
    // convertToGoogleMapsFormat($lngd.$lngm, $lngh, 'lng');

    return $nmea;
}
