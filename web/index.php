<?php

use yii\web\Application;

ini_set('display_errors', true);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require_once __DIR__ . '/../config/functions.php';

$config = require_once __DIR__ . '/../config/web.php';

if (!YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
}

(new Application($config))->run();
