<?php

function _css($file) {
    return ROOT . "css/$file.css";
}

function _js($file) {
    return ROOT . "js/$file.js";
}
function is_question_answered_by($answers, $user_id)
{
	foreach ($answers as $a) {
		if ($user_id == $a['user_id']) {
			return true;
		}
	}
	return false;
}
