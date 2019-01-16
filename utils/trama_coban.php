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

function generarTramaCoban($mensaje)
{
    // $fecha = formatFecha($UTCDateTime);
    // $velocidad = millasNauticasAKmH($speed);
    $id = $mensaje->mobileID;
    $lat = $mensaje->latitude;
    $lng = $mensaje->longitude;
    $velocidad = $mensaje->speed;
    $fecha = $mensaje->messageUTC;
    $orientacion = $mensaje->heading;
    return $trama = "imei:$id,tracker,$id,,F,$lat,$lng,$velocidad,$orientacion";
}

function formatFecha($UTCDateTime)
{
    $input = $UTCDateTime; // 181017205423
    $year = (int) substr($input, 0, 2);
    $month = (int) substr($input, 2, 2);
    $date = (int) substr($input, 4, 2);
    $hour = (int) substr($input, 6, 2);
    $minute = (int) substr($input, 8, 2);
    $seg = (int) substr($input, 10, 2);

    $date_obj = new DateTime($year . '-' . $month . '-' . $date . ' ' . $hour . ':' . $minute . '.' . $seg);
    return $date_obj->format('Y/m/d H:i.s');
}

function millasNauticasAKmH($speed)
{
    //1km/h = 1.852 milla nautica
    return $speed * 1.852;
}

/**
 * format is in ddmm.mmmm (lat) and dddmm.mmmm (lng)
 * Take the dd (lat) or ddd (lng) and add it to (mm.mmmm / 60.0).
 * If the lat value is followed by S you have to multiply it with -1. 
 * If the lng value is followed by a W, multiply it with -1.
 * e.g.: lat: 5722.5915 -> 57 + (22.5915 / 60) = 57.376525
 */
function convertDD2NMEAFormat($lat, $lng){
    $nmea = "";
    $lata = abs(Abs($lat/60000));
    $latd = abs(Truncate)($lata);
    $latm = ($lata - $latd) * 60;
    $lath = $lat > 0 ? "N" : "S";
    $lnga = abs(Abs($lng/60000));
    $lngd = abs(Truncate)($lnga);
    $lngm = ($lnga - $lngd) * 60;
    $lngh = $lng > 0 ? "E" : "W";

    $nmea += $latd.ToString("00") + $latm.ToString("00.00000") + "," + $lath + ",";
    $nmea += $lngd.ToString("000") + $lngm.ToString("00.00000") + "," + $lngh;

    return nmea;
}
