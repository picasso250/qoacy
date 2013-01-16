<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function question_GET($id)
{
	$question = new Question($id);
	$answers = $question->answers();
	render_view('master', compact('question', 'answers'));
}