<?php
//设置时区
date_default_timezone_set('Asia/Chongqing');

$rootPath = dirname(dirname(dirname(dirname(__DIR__))));
$appName = 'Web';


$vendorPath = $rootPath . '/vendor';
require $vendorPath . '/autoload.php';
$app = \Fw\App::getInstance();
$app->run($rootPath, $appName);
