<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

return array(
    'routers' => array(
        array('GET', '/', array('Index', 'index')),
        array('GET', '/search', array('Index', 'search')),
        array('POST', '/ask', array('Question', 'ask')),
        array('GET', '/question/[:id]', array('Question', 'view')),
        array('POST', '/question/[:id]/answer', array('Question', 'answer')),
        array('GET', '/login', array('Account', 'login')),
        array('GET', '/register', array('Account', 'register')),
        array('GET', '/logout', array('Account', 'logout')),
        array('GET', '/question/[:id]/[:attitude]', array('Question', 'attitude')),
        array('POST', '/comment/add', array('Question', 'comment')),
    ),

    'gender' => array(
        'male' => '男',
        'female' => '女'
    ),

    'description' => '问答',
    'keywords' => array('问答'),
);