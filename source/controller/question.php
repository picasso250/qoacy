<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function question_GET($id)
{
	$question = new Question($id);
	$answers = $question->answers();
	$answers = array_map(function ($a) {
		$a->attitudeInfo();
		$a->content = nl2br($a->content);
		return $a;
	}, $answers);
	usort($answers, function ($a, $b) {
		$goodSort = $b->goodCount - $a->goodCount;
		return $goodSort ?: ($a->badCount - $b->badCount);
	});
	$me = $GLOBALS['user'];
	add_scripts('jquery.form');
	render_view('master', compact('question', 'answers', 'me'));
}