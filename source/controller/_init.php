<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function _init()
{
    $config = $GLOBALS['config'];

    Sdb::setConfig($config['db']);

    // login
    $GLOBALS['user'] = $user = User::loggingUser(); // but the var here should be long such as $logging_user
    if ($user === false) {
        $has_login = false;
    } else {
        $has_login = true;
        $user_type = $user->type;
    }
    $GLOBALS['has_login'] = $has_login;

    // login check
    $controller = $GLOBALS['controller'];
    if (in_array($controller, $config['login_page']) && !$has_login)
        redirect("login?back=$controller/$target");

    $GLOBALS['nav'] = $navs = build_nav($config['navs']['admin']);

    $page['description'] = $config['description'];
    $page['keywords'] = $config['keywords'];
}

function _init_GET()
{
}

function _init_POST()
{
    
}
