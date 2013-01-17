<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Answer extends BasicModel
{
	private $attitudes = null;

    public static function create($info)
    {
        $info['created=NOW()'] = null;
        return parent::create($info);
    }

    public function commentCount()
    {
    	return Comment::search()->filterBy('answer', $this)->count();
    }

    public function comments()
    {
    	return Comment::search()->filterBy('answer', $this)->orderBy('id ASC')->find();
    }

    public function comment($content, User $user)
    {
    	$info = array(
    		'user' => $user,
    		'content' => $content,
    		'answer' => $this);
    	Comment::create($info);
    }

    public function attitude($action, User $user)
    {
    	if ($action === 'cancel') {
    		$conds = array('answer=? AND user=?' => array($this->id, $user->id));
    		Sdb::delete(Attitude::table(), $conds);
    		return;
    	}
    	$actionMap = array(
			'up' => 1,
			'down' => 0);
		$attitude = $actionMap[$action];
		$conds = array('answer=? AND user=? AND attitude=?' => array($this->id, $user->id, $attitude ? 0 : 1));
		Sdb::delete(Attitude::table(), $conds);
    	$info = array(
    		'attitude' => $attitude,
    		'user' => $user,
    		'answer' => $this);
    	Attitude::create($info);
    }

    public function attitudeInfo()
    {
    	$goods = $this->goodAttitudes();
		$this->goods = $goods;
		$this->goodCount = count($goods);

		$bads = $this->badAttitudes();
		$this->badCount = count($bads);

		if($GLOBALS['has_login']) {
			$me = $GLOBALS['user']->id;
			$this->byMe = $me === $this->user;

			$this->upByMe = in_array($me, array_map(function ($at) {return $at->user;}, $goods));
			$this->downByMe = in_array($me, array_map(function ($at) {return $at->user;}, $bads));
		}
    }

    public function attitudes()
    {
    	if ($this->attitudes === null)
	    	$this->attitudes = Attitude::search()->filterBy('answer', $this)->orderBy('id DESC')->find();
	    return $this->attitudes;
    }

    public function goodAttitudes()
    {
    	$goods = array_filter($this->attitudes(), function ($at) {
    		return $at->attitude;
    	});
    	return $goods;
    }
    public function badAttitudes()
    {
    	$bads = array_filter($this->attitudes(), function ($at) {
    		return !$at->attitude;
    	});
    	return $bads;
    }
}
