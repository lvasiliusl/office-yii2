<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
require(realpath(__DIR__ . '/../vendor/autoload.php'));
require(realpath(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php'));
require(realpath(__DIR__ . '/../common/config/bootstrap.php'));
require(realpath(__DIR__ . '/../frontend/config/bootstrap.php'));

$config = yii\helpers\ArrayHelper::merge(
    require(realpath(__DIR__ . '/../common/config/main.php')),
    require(realpath(__DIR__ . '/../common/config/main-local.php')),
    require(realpath(__DIR__ . '/../frontend/config/main.php')),
    require(realpath(__DIR__ . '/../frontend/config/main-local.php'))
);

(new yii\web\Application($config))->run();
