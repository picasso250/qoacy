<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function ask_question_POST()
{
	$title = _req('title');
	$user = $GLOBALS['user'];
	if (!$user) {
		redirect();
	}
	$q = Question::create(compact('title', 'user'));
	redirect("question/$q->id");
}