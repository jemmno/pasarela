<?php

$output = shell_exec('ps -c php -f');
if (strpos($output, "php yii pasarela/escuchar")===false) { 
  shell_exec('php yii pasarela/escuchar  > running.log 2>&1 &');
}