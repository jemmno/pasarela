<?php

$output = shell_exec('ps -C php -f');
if (strpos($output, "php /var/www/pasarela/yii pasarela/escuchar")===false) {
  shell_exec('nohup php /var/www/pasarela/yii pasarela/escuchar  > /var/www/pasarela/running.log 2>&1 &');
}
