<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function login_init()
{
	$GLOBALS['data'] = array();
}

function login_POST()
{
	$username = _post('username');
	$password = _post('password');
	if ($user = User::check($username, $password)) {
		$user->login();
		redirect();
	} else {
		$msg = 'wrong user name or password';
		$GLOBALS['data']['msg'] = $msg;
		$GLOBALS['data']['username'] = $username;
	}
}

function login_end()
{
	add_scripts('jquery.validate.min');
	render_view('master', $GLOBALS['data']);
}