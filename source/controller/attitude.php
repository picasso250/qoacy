<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function attitude()
{
	if (!$GLOBALS['has_login'])
		exit;
	$id = _req('id'); // id of answer
	$action = _req('action');
	$answer = new Answer($id);
	$answer->attitude($action, $GLOBALS['user']);
}