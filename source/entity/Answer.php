<?php

use ptf\IdEntity;

class Answer extends IdEntity
{

    public function init($arr)
    {
        $this->html = nl2br($this->content);
    }

}