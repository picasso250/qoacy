<?php

use ptf\IdDao;

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class CommentDao extends IdDao
{
	public function add($arr)
	{
		$arr['created'] = $this->now();
		return parent::add($arr);
	}
}
