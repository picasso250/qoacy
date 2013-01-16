<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function register_init()
{
	$GLOBALS['data'] = array();
}

function register_POST()
{
	$email = _post('email');
	$password = _post('password');
	if ($email && $password) {
		$user = User::create(compact('email', 'password'));
		$user->login();
		redirect();
	}
	$GLOBALS['data']['email'] = $email;
}

function register_end()
{
	render_view('master', $GLOBALS['data']);
}