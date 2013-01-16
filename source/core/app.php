<?php
/**
 * 这个文件定义了一系列全局函数，用来操作APP
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function init_var()
{
    // don't use $_SERVER['REDIRECT_URL'], it is not good for urldecode()
    $GLOBALS['req_uri'] = $req_uri = reset(explode('?', $_SERVER['REQUEST_URI']));
    define('SELF_PAGE', $req_uri);
    $arr = explode('/', trim($req_uri, '/'));

    // we should use function here
    $GLOBALS['by_ajax'] = i($_REQUEST['is_ajax']) || (strtolower(i($_SERVER['HTTP_X_REQUESTED_WITH'])) == strtolower('XMLHttpRequest'));
    $GLOBALS['by_post'] = strtolower(i($_SERVER['REQUEST_METHOD'])) == 'post';

    $GLOBALS['page'] = array(
        'title'   => $GLOBALS['config']['site']['name'],
        'head'    => array(), // 在head里面的语句
        'scripts' => array(), // 页面底部的script
        'styles'  => array(), // head里面的css
        'append_divs' => array(), // 附加的对话框
    ); // 关于这个页面的变量
}

function init_env()
{
    ob_start();
    session_start();
    date_default_timezone_set('PRC');

    // auto require when using class (model or lib)
    spl_autoload_register(function ($classname) {
        $filename = str_replace('\\', DS, $classname) . '.php';
        $model_file = APP_ROOT . 'model' . DS . $filename;
        $lib_file = CORE_ROOT . 'lib' . DS . $filename;
        if (file_exists($model_file)) 
            require_once $model_file;
        elseif (file_exists($lib_file))
            require_once $lib_file;
    });

    if (!isset($GLOBALS['by_ajax']) || !$GLOBALS['by_ajax']) {
        set_exception_handler(function ($exception) {
            echo '</span></p></table></div>', "\n";
            echo '<p style="display:block;clear:both;">Exception in ', $exception->getFile(), ' : ', $exception->getLine(), '</p>', "\n";
            echo '<strong>', $exception->getMessage(), '</strong>', "\n";
            echo '<p>Stack Trace:</p>', "\n";
            echo '<pre>', $exception->getTraceAsString(), '</pre>';
            exit();
        });
    }
}

function execute_logic()
{
    $req_uri = $GLOBALS['req_uri'];
    $url = $GLOBALS['config']['urls'];

    // search for controller
    foreach ($url as $pattern => $controller) {
        $pattern = str_replace('/', '\/', $pattern);
        if (preg_match('/^'.$pattern.'$/', $req_uri, $matches)) {
            // find!
            $find_controller = 1;
            break;
        }
    }
    if (!isset($find_controller)) {
        $controller = 'page404';
    }
    $GLOBALS['view'] = $GLOBALS['controller'] = $controller;

    $method = $_SERVER['REQUEST_METHOD'];

    $init_file = AppFile::controller('_init');
    if (file_exists($init_file)) {
        require_once $init_file;
    }

    $init_function_name = '_init';
    if (function_exists($init_function_name)) {
        call_user_func($init_function_name);
    }
    $init_function_name .= '_'.$method;
    if (function_exists($init_function_name)) {
        call_user_func($init_function_name);
    }

    if (isset($matches))
        array_shift($matches);
    require_once AppFile::controller($controller);
    if (function_exists($controller)) {
        call_user_func($controller);
    }
    $method_func = $controller.'_'.$method;
    if (function_exists($method_func))
        call_user_func_array($method_func, $matches);
}

function render_view($view_file, $opts = array())
{
    extract($opts);
    include AppFile::view($view_file); // 渲染 view
}

function add_scripts($names)
{
    if (!is_array($names) && is_string($names)) {
        $names = array($names);
    }
    $GLOBALS['page']['scripts'] = $GLOBALS['page']['scripts'] + $names;
}

function add_styles($names)
{
    if (!is_array($names) && is_string($names)) {
        $names = array($names);
    }
    $GLOBALS['page']['styles'] = $GLOBALS['page']['styles'] + $names;
}

function get_controller_by_url($url)
{
    $urls = $GLOBALS['config']['urls'];
    return isset($urls[$url]) ? $urls[$url] : false;
}
