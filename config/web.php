<?php

return [
    'id' => 'test',
    'basePath' => realpath(__DIR__ . '/../'),
    'language' => 'ru',
    'defaultRoute' => 'task/index',
    'components' => [
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'Eaf5riKYa63nuDeHSvOPTaGAgulFoB',
            'baseUrl' => ''
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'db' => require_once __DIR__ . '/db.php',
        'user' => [
            'enableAutoLogin' => true,
            'identityClass' => 'app\models\UserModel',
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
        ],
    ],
];
