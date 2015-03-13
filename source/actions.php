<?php
function index_GET()
{
    $questions = Service('db')->get_all_question(100);
    render(VIEW_ROOT.'/index.html', compact('questions'), LAYOUT_PATH);
}
function login()
{
    render(VIEW_ROOT.'/login.html', compact('questions'), LAYOUT_PATH);

}
