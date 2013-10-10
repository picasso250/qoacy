<?php

use ptf\IdDao;

class Answer extends IdDao
{
    public $commentDao;
    public function __construct()
    {
        $this->commentDao = new CommentDao;
    }

    public function add($arr)
    {
        $arr['created'] = $this->now();
        return parent::add($arr);
    }

    public function getComments()
    {
        return $this->commentDao
                ->where('answer_id', $this->id)
                ->orderBy(array('id' => 'ASC'))
                ->findMany();
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
            $this->attitudes = Attitude::search()->where('answer_id', $this->id)->orderBy('id DESC')->findMany();
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