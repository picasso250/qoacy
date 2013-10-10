<?php

class Question extends IdDao
{
    public function __construct()
    {
        $this->answerDao = new AnswerDao;
    }
    public function getAnswers()
    {
        return $this->answerDao
                ->where('question_id', $this->id)
                ->orderBy(array(
                    'good_count' => 'desc',
                    'bad_count' => 'asc',
                ))
                ->findMany();
    }

    public function getAnswerCount()
    {
        return Answer::search()->filterBy('question', $this)->count();
    }
}