<?php
function index_GET()
{
    $questions = Service('db')->get_all_question(100);
    render(VIEW_ROOT.'/index.html', compact('questions'), LAYOUT_PATH);
}
function login_ajax()
{
	list($ok, $msg) = user_login();
	if ($ok) {
		echo json(['url' => _get('back', '/')]);
	} else {
		echo json(1, $msg);
	}
}
function login()
{
    render(VIEW_ROOT.'/login.html', compact('questions'), LAYOUT_PATH);
}

function register_ajax()
{
	$message = '';
	$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	$password = _post('password');
	if (empty($email)) {
		$message = '邮箱不正确';
	} elseif (empty($password)) {
		$message = '密码必填';
	}
	if ($message) {
		return [false, $message];
	}
	$db = Service('db');
	$db->beginTransaction();
	try {
		$user = $db->get_user_by_email($email);
		if ($user) {
			echo json(1, '此用户已经存在');
			return;
		}
		error_log("$email register, $password");
		$id = $db->insert('user', [
			'email' => $email,
			'password' => md5($password),
		]);
		user_id($id);
		$db->commit();
		echo json(['url' => '/']);
	} catch (Exception $e) {
		$db->rollback();
		throw $e;
	}
}

function register()
{
	render(VIEW_ROOT.'/register.html', [], LAYOUT_PATH);
}
function logout()
{
	user_id(0);
	redirect('/');
}
function search()
{
	$q = _get('q');
	if ($q)
		$questions = Service('db')->queryAll('SELECT * from question where title like ? limit 100', ["%$q%"]);
	else
		$questions = array();
    render(VIEW_ROOT.'/search.html', compact('q', 'questions'), LAYOUT_PATH);
}
