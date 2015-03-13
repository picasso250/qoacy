<?php
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * app logic
 */

include __DIR__.'/PHP-tiny/autoload.php';

date_default_timezone_set('PRC');

define('SRC_ROOT', __DIR__.'/source');
define('CONFIG_ROOT', __DIR__.'/source/config');

$config = load_config(CONFIG_ROOT.'/main.json', CONFIG_ROOT.'/env.json');
Service('config', $config);
$dbc = $config['db'];
Service('db', new DB($dbc['dsn'], $dbc['username'], $dbc['password']));

run(array_map(function($router) {
	return [$router[1], function ($params) {
		list($cc, $a) = $routers[2];
		$c = new $cc;
		$c->$a($params);
	}];
}, $config['routers']));
