<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function login_GET()
{
	render_view('master');
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
		render_view('master', compact('username', 'msg'));
	}
}