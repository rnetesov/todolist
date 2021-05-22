<?php

return [
    'id' => 'test',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\commands',
    'components' => [
        'db' => require_once __DIR__ .'/db.php',
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ]
    ],
];