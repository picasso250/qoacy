<?php
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * app logic
 */

include __DIR__.'/PHP-tiny/autoload.php';
include __DIR__.'/PHP-tiny/ptf/account.php';

date_default_timezone_set('PRC');

define('ROOT', '/');

define('SRC_ROOT', __DIR__.'/source');
include SRC_ROOT.'/actions.php';
include SRC_ROOT.'/logic.php';

session_start();

define('CONFIG_ROOT', __DIR__.'/source/config');
define('VIEW_ROOT', SRC_ROOT.'/view');
define('LAYOUT_PATH', VIEW_ROOT.'/layout/master.html');

$config = load_config(CONFIG_ROOT.'/main.json', CONFIG_ROOT.'/env.json');
Service('config', $config);
$dbc = $config['db'];
$db = new DB($dbc['dsn'], $dbc['username'], $dbc['password']);
Service('db', $db);
$user_id = user_id();
Service('user', $user_id ? $db->get_user_by_id($user_id) : null);

run($config['routers'], function()
{
	exit('page 404');
});
