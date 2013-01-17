<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION'); // in fact, even if this is exucted by user, would it show anything?
/**
 * @file    common
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 10:38:22 AM
 */

define('PRD', 0);
define('DEBUG', 1);

if (isset($_SERVER['HTTP_APPNAME'])) { // on sae
    define('ON_SERVER', TRUE);
    define('UP_DOMAIN', 'xxx');
} else {
    define('ON_SERVER', FALSE);
}

define('ROOT', '/');

define('DEFAULT_LOGIN_REDIRECT_URL', ROOT); // 登录后的默认导向页面

$config['urls'] = array(
    '/' => 'index',
    '/search' => 'search',
    '/ask_question' => 'ask_question',
    '/question/(.+)' => 'question',
    '/answer_question/(.+)' => 'answer_question',
    '/login' => 'login',
    '/register' => 'register',
    '/logout' => 'logout',
    '/attitude' => 'attitude',
    '/get_comment_div' => 'get_comment_div',
    '/comment/(.+)' => 'comment');

// pages need login
$config['login_page'] = array();

$config['admin_page'] = array();

$config['db'] = array(
    'host' => 'localhost',
    'dbname' => 'qoacy',
    'username' => 'root',
    'password' => 'root'
);

if (PRD) {
    $config['db'] = array(
        'host' => 'localhost',
        'dbname' => 'cpjewenmond',
        'username' => 'jeweng_dbu',
        'password' => 'rty2fADYYL7r8mZK'
    );
}

if (ON_SERVER) {
    // 会覆盖之前的配置
    $config['db'] = array(
        'master' => array('host' => SAE_MYSQL_HOST_M),
        'slave'  => array('host' => SAE_MYSQL_HOST_S),
        'port'   => SAE_MYSQL_PORT,
        'dbname' => SAE_MYSQL_DB,
        'username' => SAE_MYSQL_USER,
        'password' => SAE_MYSQL_PASS
    );
    
}

if (ON_SERVER || PRD) {
    include 'server.php';
} else {
    define('JS_VER',  time());
    define('CSS_VER', time());
}

// 数据库名
define('cart_product', 'cart_product');
define('customer_address', 'customer_address');

include 'content.php';
