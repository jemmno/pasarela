<?php

$output = shell_exec('ps -C php -f');
if (strpos($output, "php yii pasarela/escuchar")===false) { 
  shell_exec('nohup php /var/www/pasarela/yii pasarela/escuchar  > running.log 2>&1 &');
}