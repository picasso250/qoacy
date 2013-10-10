<?php

use ptf\IdDao;

class AttitudeDao extends IdDao
{

    public function add($arr)
    {
        $arr['created'] = $this->now();
        return parent::add($arr);
    }

}