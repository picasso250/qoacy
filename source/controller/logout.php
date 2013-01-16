<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function logout()
{
	if ($GLOBALS['has_login']) {
		$GLOBALS['user']->logout();
	}
	redirect();
}