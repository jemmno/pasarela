<?php

/**
 * formato trama hawk
 * HAWK;ID=XXXX; -37,12939;-56,86765; 50; 125;2012-10-10 15:05.09; 0; 1; 5; 15,5; 0 ;
 * HAWK Identificador tipo trama
 * XXXX ID del Equipo (La patente de la unidad,hasta 7 caracteres alfanuméricos)
 * -37,12939 Latitud
 * -56,86765 Longitud
 * 50 Velocidad (Km/h)
 * 125 Sentido (Grados)
 * 20120925 18:25.123 Fecha del equipo – Fecha y hora UTC (yyyyMMdd HH:mm:ss.fff)
 * 0 Ignición (0 Off – 1 On)
 * 1 Edad del dato (0 Vieja - 1 Nueva - 2 No Disponible)
 * 5 Numero de Evento
 * 15,5 Entrada Analógica 1 en XX,X Volt
 * 0 Entrada Analógica 2 en XX,X Volt
 * 1254,5 Odómetro en metros del equipo
 *
 */

function generarTramaHawk($patente, $lat, $lng, $speed, $UTCDateTime, $direction, $ACC, $door, $dif_horaria)
{
    $fecha = formatFecha($UTCDateTime, $dif_horaria);
    $velocidad = millasNauticasAKmH($speed);
    $ACC = IsNullOrEmptyString($ACC) ? '' : $ACC;
    $door = IsNullOrEmptyString($door) ? '' : $door;
    $evento = mapEvento($ACC, $door);

    return $trama = "HAWK;ID=$patente;$lat;$lng;$velocidad;$direction;$fecha;$ACC;1;$evento;;;;";
}

function mapEvento($ACC, $door)
{
    $evento = '';
    if($door == 1) { $evento = 11; }
    if($door == 0) { $evento = 12; }
    return $evento;
}

function formatFecha($UTCDateTime, $dif_horaria)
{
    $input = $UTCDateTime; // 181017205423
    $year = (int) substr($input, 0, 2);
    $month = (int) substr($input, 2, 2);
    $date = (int) substr($input, 4, 2);
    $hour = (int) substr($input, 6, 2);
    $minute = (int) substr($input, 8, 2);
    $seg = (int) substr($input, 10, 2);

    $date_obj = new DateTime($year . '-' . $month . '-' . $date . ' ' . $hour . ':' . $minute . '.' . $seg);
    $date_obj->modify($dif_horaria.' hour');
    return $date_obj->format('Y/m/d H:i.s');
}

function millasNauticasAKmH($speed)
{
    //1km/h = 1.852 milla nautica
    return $speed * 1.852;
}
