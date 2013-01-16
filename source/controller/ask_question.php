<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function ask_question_POST()
{
	$title = _req('title');
	$q = Question::create(compact('title'));
	redirect("question/$q->id");
}