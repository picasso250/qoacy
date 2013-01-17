<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function question_GET($id)
{
	$question = new Question($id);
	$answers = $question->answers();
	$answers = array_map(function ($a) {
		$goods = $a->goodAttitudes();
		$bads = $a->badAttitudes();
		$a->goods = $goods;
		$a->goodCount = count($goods);
		$me = $GLOBALS['user']->id;
		$a->byMe = $me === $a->user;
		$a->upByMe = in_array($me, array_map(function ($at) {return $at->user;}, $goods));
		$a->downByMe = in_array($me, array_map(function ($at) {return $at->user;}, $bads));
		return $a;
	}, $answers);
	usort($answers, function ($a, $b) {
		return - $a->goodCount + $b->goodCount;
	});
	render_view('master', compact('question', 'answers'));
}