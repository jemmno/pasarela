<?php
/* @var codemix\yii2confload\Config $this */

use codemix\yii2confload\Config;
$web = $this->web();

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'timeZone' => 'America/Asuncion', // time zone
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'd-M-Y',
            'datetimeFormat' => 'd-M-Y H:i:s',
            'timeFormat' => 'H:i:s',

            'locale' => 'es-PY', //your language locale
            'defaultTimeZone' => 'America/Asuncion', // time zone
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'flushInterval' => 1,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'exportInterval' => 1,
                    'levels' => ['info'],
                    'categories' => ['pasarela'],
                    'logVars' => [],
                    'logFile' => '@runtime/logs/pasarela.log',
                    'maxFileSize' => 5120,
                    'maxLogFiles' => 100,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'exportInterval' => 1,
                    'levels' => ['info'],
                    'categories' => ['global'],
                    'logVars' => [],
                    'logFile' => '@runtime/logs/global.log',
                    'maxFileSize' => 5120,
                    'maxLogFiles' => 100,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'exportInterval' => 1,
                    'levels' => ['info'],
                    'categories' => ['ejecucion'],
                    'logVars' => [],
                    'logFile' => '@runtime/logs/ejecucion.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'exportInterval' => 1,
                    'levels' => ['info'],
                    'categories' => ['satelital'],
                    'logVars' => [],
                    'logFile' => '@runtime/logs/satelital.log',
                    'maxFileSize' => 5120,
                    'maxLogFiles' => 100,
                ],
            ],
        ],
        'db' => $web['components']['db'],
    ],
    'params' => $params,
    /*
'controllerMap' => [
'fixture' => [ // Fixture generation command line.
'class' => 'yii\faker\FixtureController',
],
],
 */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
