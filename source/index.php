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

if (isset($_SERVER['HTTP_APPNAME'])) { // on sae
    define('ON_SERVER', TRUE);
    define('UP_DOMAIN', 'xxx');
} else {
    define('ON_SERVER', FALSE);
}

define('APP_ROOT', __DIR__ . DS);
define('CORE_ROOT', APP_ROOT . 'core' . DS);

include APP_ROOT . 'config/common.php';

// if not debug, mute all error reportings
if (!(defined('DEBUG') ? DEBUG : 0)) {
    ini_set('display_errors', 0);
    error_reporting(0);
}

require CORE_ROOT . 'function.php';
require CORE_ROOT . 'app.php';
init_var();
init_env();

$user_lib_file = APP_ROOT . 'lib' . DS . 'function.php';
if (file_exists($user_lib_file))
    require_once $user_lib_file;

execute_logic();
