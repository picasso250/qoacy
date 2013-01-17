<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function get_comment_div()
{
	$id = _req('id'); // id of answer
	$answer = new Answer($id);
	$comments = $answer->comments();
	render_view('comments', compact('comments', 'answer'));
}
