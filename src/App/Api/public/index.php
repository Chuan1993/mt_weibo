<?php
//设置时区
date_default_timezone_set('Asia/Chongqing');

//ini_set('display_errors', 'off');

$rootPath = dirname(dirname(dirname(dirname(__DIR__))));
$appName = 'Api';
$suffixes = ['json'];


$vendorPath = $rootPath . '/vendor';
require $vendorPath . '/autoload.php';
$app = \Fw\App::getInstance();
$app->beforeRoute(function(\Fw\Request $request, \Fw\App $app) {
})
    ->setSupportedSuffixes($suffixes)
    ->run($rootPath, $appName);