<?php

use ptf\IdEntity;

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class User extends IdEntity
{
    public function changePassword($newPassword)
    {
        $this->password = md5($newPassword);
        return $this->save();
    }

    public function login()
    {
        $_SESSION['se_user_id'] = $this->id;
    }

    public function logout()
    {
        $_SESSION['se_user_id'] = 0;
    }

}
