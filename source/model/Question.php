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

    public function answer($content)
    {
    	$info['content'] = $content;
    	$info['question'] = $this->id;
    	return Answer::create($info);
    }

    public function answers()
    {
        return Answer::search()->filterBy('question', $this)->find();
    }
}
