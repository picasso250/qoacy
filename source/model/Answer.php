<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Answer extends BasicModel
{
    public static function create($info)
    {
        $info['created=NOW()'] = null;
        return parent::create($info);
    }
}
