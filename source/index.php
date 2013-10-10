<?php
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * app logic
 * 此框架由王霄池纯粹手写而成，当然参照了不少鸡爷的框架，也参照了 LazyPHP
 */

// 打开错误提示
ini_set('display_errors', 1); // 在 SAE 上 ini_set() 不起作用，但也不会报错
error_reporting(E_ALL);

use ptf\Application;
use ptf\PdoWrapper;

if (isset($_SERVER['HTTP_APPNAME'])) {
    define('DEPLOY_ENV', 'prd');
} else {
    define('DEPLOY_ENV', 'dev');
}

include __DIR__.'/autoload.php';

date_default_timezone_set('PRC');

$app = new Application;
$app->root = __DIR__;
$config = array_merge(
    require __DIR__.'/config/config.php',
    require __DIR__.'/config/config.'.DEPLOY_ENV.'.php'
);
PdoWrapper::config($config['db']);
$app->config($config);
$app->run();

