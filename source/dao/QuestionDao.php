<?php

use ptf\IdDao;

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class QuestionDao extends IdDao
{
    public function add($info)
    {
        $info['created'] = $this->now();
        return parent::add($info);
    }

    public function getAnswers()
    {
        $answerDao = new AnswerDao;
        return $this->answerDao->where('question_id', $this->id)->findMany();
    }

    public function isAnsweredBy(User $user, $answers)
    {
        foreach ($answers as $a) {
            if ($a->user_id == $user->id) {
                return true;
            }
        }
        return false;
    }
}
