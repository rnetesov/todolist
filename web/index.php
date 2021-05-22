<?php

use yii\web\Application;

ini_set('display_errors', true);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require_once __DIR__ .'/../vendor/autoload.php';
require_once __DIR__ .'/../vendor/yiisoft/yii2/Yii.php';
require_once __DIR__. '/../config/functions.php';

$config = require_once __DIR__ . '/../config/web.php';

(new Application($config))->run();
