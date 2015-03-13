<?php
function index_GET()
{
    $questions = Question::search()->find();
    render_view('master', compact('questions'));
}
