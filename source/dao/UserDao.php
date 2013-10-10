<?php

use ptf\IdDao;

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class UserDao extends IdDao
{
    public function add($info)
    {
        $info['created'] = $this->now();
        return parent::add($info);
        
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->findOne();
    }

    public function check($username, $password)
    {
        return $this->where(array(
                'email' => $username,
                'password' => md5($password),
            ));
    }

    public function changePassword($newPassword)
    {
        $this->update('password', md5($newPassword));
    }

    public function login()
    {
        $_SESSION['se_user_id'] = $this->id;
    }

    public function logout()
    {
        $_SESSION['se_user_id'] = 0;
    }

    public static function loggingUser()
    {
        if (isset($_SESSION['se_user_id']) && $_SESSION['se_user_id']) {
            return new self($_SESSION['se_user_id']);
        } else {
            return false;
        }
    }
}
