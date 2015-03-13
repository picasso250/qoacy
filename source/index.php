<?php
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * app logic
 */

include __DIR__.'/vendor/autoload.php';

date_default_timezone_set('PRC');

$config = array_merge(
	json_decode(file_get_contents(__DIR__.'/config/main.json')),
	json_decode(file_get_contents(__DIR__.'/config/env.json'))
);
Service('config', $config);
$dbc = $config['db'];
Service('db', new DB($dbc['dsn'], $dbc['username'], $dbc['password']));

run($config['routers']);
