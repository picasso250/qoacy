<?php
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function index_GET()
{
	$questions = Question::search()->find();
    render_view('master', compact('questions'));
}