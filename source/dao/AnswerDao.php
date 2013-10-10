<?php

use ptf\IdDao;

class AnswerDao extends IdDao
{

    public function add($arr)
    {
        $arr['created'] = $this->now();
        return parent::add($arr);
    }

    public function getComments()
    {
        $commentDao = new CommentDao;
        return $commentDao
                ->where('answer_id', $this->id)
                ->orderBy(array('id' => 'ASC'))
                ->findMany();
    }

    public function upVote($user_id)
    {
        return $this->attitude($user_id, 1);
    }

    public function downVote($user_id)
    {
        return $this->attitude($user_id, -1);
    }

    public function attitude($user_id, $attitude)
    {
        $attitudeDao = new AttitudeDao();
        return $attitudeDao->add(array(
                'user_id' => $user_id,
                'attitude' => $attitude,
                'answer_id' => $this->id,
            ));
    }

    public function getAttitudes()
    {
        $attitudeDao = new AttitudeDao();
        return $attitudeDao
                ->where('answer_id', $this->id)
                ->orderBy(array('id' => 'DESC'))
                ->findMany();
    }

}