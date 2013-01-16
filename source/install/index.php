<?php

// 打开错误提示
ini_set('display_errors', 1); // 在 SAE 上 ini_set() 不起作用，但也不会报错
error_reporting(E_ALL);

define('IN_APP', 1);

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', __DIR__ . DS . '..' . DS);
define('CORE_ROOT', APP_ROOT . 'core' . DS);

include APP_ROOT . 'config/common.php';

require CORE_ROOT . 'function.php';
require CORE_ROOT . 'app.php';
init_env();

if (isset($_SERVER['HTTP_APPNAME']))
    define('ON_SAE', 1);
else 
    define('ON_SAE', 0);

$c = $config['db'];
if (!ON_SAE)
    $c['dbname'] = '';
Pdb::setConfig($c);

$histories = array();

$sqls = explode(';', file_get_contents('install.sql'));
foreach ($sqls as $sql) {
    exec_sql($sql);
}

$sqls = explode(';', file_get_contents('default_data.sql'));
foreach ($sqls as $sql) {
    exec_sql($sql);
}

function dd($str)
{
    echo "<p>$str</p>\n";
}

function exec_sql($sql = '')
{
    if (ON_SAE && preg_match('/USE|CREATE\sDATABASE/', $sql)) {
        return;
    }
    Pdb::exec($sql);
    $GLOBALS['histories'][] = $sql;
}
?>
<p>install ok</p>
<p><a href="/test/index.php">if you need test</a><p>
<p>or just go to <a href="/">index</a></p>
