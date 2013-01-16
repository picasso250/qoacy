<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('IN_APP', 1);

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', __DIR__ . DS . '..' . DS);
define('CORE_ROOT', APP_ROOT . 'core' . DS);

include APP_ROOT . 'config/common.php';

require CORE_ROOT . 'function.php';
require CORE_ROOT . 'app.php';
init_env();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <title>Test for Cheng</title>
    <link rel="stylesheet" type="text/css" href="static/style.css" />
</head>
<body>
    <h1><a href="?">Test for Cheng</a></h1>
    <a href="/">exit</a>
    <a class="clear btn" href="?exit=1">clear all side effects in db</a>
    <div class="conclusion fail" id="pre-box">SOME FAIL!</div>
    <ol><?php include 'test.php'; ?></ol>
    <div class="conclusion <?= $all_pass? 'pass' : 'fail' ?>"><?= $all_pass? 'ALL PASS' : 'SOME FAIL!' ?></div>
    <script src="static/hide.js"></script>
</body>
</html>
