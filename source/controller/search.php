<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function search_GET()
{
	$q = _get('q');
    render_view('master', compact('q'));
}