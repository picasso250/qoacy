<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function comment($id)
{
	if (!$GLOBALS['has_login'])
		exit;
	$answer = new Answer($id);
	$content = _req('content');
	if ($content)
		$answer->comment($content, $GLOBALS['user']);

	$comments = $answer->comments();
	render_view('comments', compact('comments', 'answer'));
}
