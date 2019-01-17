<?php

$output = shell_exec('ps -C php -f');
if (strpos($output, "php /var/www/pasarela/yii pasarela/escuchar")===false) {
  shell_exec('nohup php /var/www/pasarela/yii pasarela/escuchar  > /var/www/pasarela/running_gsm.log 2>&1 &');
}

if (strpos($output, "php /var/www/pasarela/yii satelital/preguntar")===false) {
  shell_exec('nohup php /var/www/pasarela/yii satelital/preguntar  > /var/www/pasarela/running_satelital.log 2>&1 &');
}