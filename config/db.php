<?php
/* @var codemix\yii2confload\Config $this */

return [
    'class' => 'yii\db\Connection',
    'dsn' => self::env('DB_DSN', 'mysql:host=db;dbname=web'),
    'username' => self::env('DB_USER', 'web'),
    'password' => self::env('DB_PASSWORD', 'web'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
