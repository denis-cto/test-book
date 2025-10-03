<?php

// Load environment variables
require __DIR__ . '/env-loader.php';

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$sms = require __DIR__ . '/sms.php';
$app = require __DIR__ . '/app.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $app['cookieValidationKey'],
            'enableCsrfValidation' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['sms'],
                    'logFile' => '@runtime/logs/sms.log',
                    'levels' => ['info', 'error'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['debug'],
                    'logFile' => '@runtime/logs/debug.log',
                    'levels' => ['info'],
                ],
            ],
        ],
        'db' => $db,
        'sms' => $sms,
        'notification' => [
            'class' => 'app\components\NotificationComponent',
        ],
        'stats' => [
            'class' => 'app\components\StatsComponent',
        ],
        'reportService' => [
            'class' => 'app\services\ReportService',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
