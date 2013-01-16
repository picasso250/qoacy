<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Question extends BasicModel
{
    public static function create($info)
    {
        $info['created=NOW()'] = null;
        return parent::create($info);
    }

    public function answer($content, $user)
    {
    	$info['content'] = $content;
    	$info['question'] = $this->id;
        $info['user'] = $user->id;
    	return Answer::create($info);
    }

    public function answers()
    {
        return Answer::search()->filterBy('question', $this)->find();
    }

    public function answeredBy(User $user)
    {
        $conds = array('user=? AND question=?' => array($user->id, $this->id));
        return Sdb::fetchRow('id', Answer::table(), $conds) !== false;
    }
}
