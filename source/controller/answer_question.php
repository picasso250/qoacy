<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function answer_question_POST($id)
{
	$content = _post('content');
	$q = new Question($id);
	$q->answer($content);
	redirect("question/$q->id");
}