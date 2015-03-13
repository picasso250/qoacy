<?php
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * app logic
 */

include __DIR__.'/PHP-tiny/autoload.php';

date_default_timezone_set('PRC');

define('ROOT', '/');

define('SRC_ROOT', __DIR__.'/source');
include SRC_ROOT.'/actions.php';
include SRC_ROOT.'/logic.php';

define('CONFIG_ROOT', __DIR__.'/source/config');
define('VIEW_ROOT', SRC_ROOT.'/view');
define('LAYOUT_PATH', VIEW_ROOT.'/layout/master.html');

$config = load_config(CONFIG_ROOT.'/main.json', CONFIG_ROOT.'/env.json');
Service('config', $config);
$dbc = $config['db'];
Service('db', new DB($dbc['dsn'], $dbc['username'], $dbc['password']));

run($config['routers']);
