<?php

class Answer extends IdDao
{

    public function init($arr)
    {
        $this->html = nl2br($this->content);
    }

}