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
function ask()
{
    $title = _post('title');
    if (empty($title)) {
    	echo json(1, '问题为空');
    }
    $id = Service('db')->insert('question', array(
                'title' => $title,
                'user' => user_id(),
            ));
    echo json(['url' => "/question/$id"]);
}
function Question_view($params)
{
	$id = $params['id'];
    $question = Service('db')->get_question_by_id($id);
    $answers = Service('db')->queryAll('SELECT * from answer where question_id=? order by good_count desc, bad_count asc limit 1000', [$id]);
    foreach ($answers as &$answer) {
    	$answer['user'] = Service('db')->get_user_by_id($answer['user_id']);
    }
    render(VIEW_ROOT.'/question.html', compact('question', 'answers'), LAYOUT_PATH);
}
function answer($params)
{
	$id = $params['id'];
    $content = _post('content');
    Service('db')->insert('answer', array(
            'question_id' => $id,
            'content' => $content,
            'user_id' => user_id(),
        ));
    echo json(0);
}
