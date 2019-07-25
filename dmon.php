<?php

$output = shell_exec('ps -C php -f');
if (strpos($output, "php /var/www/html/pasarela/yii pasarela/escuchar")===false) {
  shell_exec('nohup php /var/www/html/pasarela/yii pasarela/escuchar  > /dev/null 2>&1 &');
}

if (strpos($output, "php /var/www/html/pasarela/yii satelital/preguntar")===false) {
  shell_exec('nohup php /var/www/html/pasarela/yii satelital/preguntar  > /dev/null 2>&1 &');
}
