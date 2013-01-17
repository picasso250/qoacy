<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function search_GET()
{
	$q = _get('q');
	if ($q)
		$questions = Question::search()->filterBy('title', "%$q%", 'LIKE')->find();
	else
		$questions = array();
    render_view('master', compact('q', 'questions'));
}