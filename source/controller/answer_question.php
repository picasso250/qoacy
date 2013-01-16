<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function answer_question_POST($id)
{
	if (!$GLOBALS['has_login'])
		redirect();
	$user = $GLOBALS['user'];
	$content = _post('content');
	$q = new Question($id);
	$q->answer($content, $user);
	redirect("question/$q->id");
}