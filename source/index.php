<?php
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * app logic
 */

use ptf\Application;
use ptf\PdoWrapper;

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

