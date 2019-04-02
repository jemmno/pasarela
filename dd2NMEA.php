<?php

$lat = '-22.4184333';
$lng = '-60.1568333';

print convertDD2NMEAFormat($lat, $lng);

function convertDD2NMEAFormat($lat, $lng){
    $nmea = $nmelat = $nmealng = "";
    $lata = abs((float)$lat); //le quita el signo
    $latd = intval($lata); //obtiene la parte entera del float
    $latm = ($lata - $latd) * 60.0;
    print "\n".$latd."   ".$latm."\n";
    $lath = $lat > 0 ? "N" : "S";
    
    $lnga = abs((float)$lng);
    //echo ("\n $lnga")."    ".($lnga*0.10);
    $lngd = intval($lnga);
    $lngm = ($lnga - $lngd) * 60.0;
    $lngh = $lng > 0 ? "E" : "W";
    print "\n".$lngd."   ".$lngm."\n";

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
    //convertToGoogleMapsFormat($latd.$latm, $lath, 'lat');
    //convertToGoogleMapsFormat($lngd.$lngm, $lngh, 'lng');

    return $nmea;
}
