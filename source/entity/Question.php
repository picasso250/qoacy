<?php

use ptf\IdEntity;

class Question extends IdEntity
{
    public function __construct()
    {
        $this->answerDao = new AnswerDao;
    }
    
    public function getAnswers()
    {
        
    }

    public function getAnswerCount()
    {
        return Answer::search()->filterBy('question', $this)->count();
    }
}
