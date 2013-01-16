<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class User extends BasicModel
{
    public static function has($username)
    {

        $info = Sdb::fetchRow('*', self::$table, array('name=?' => $username));
        return $info ? new self($info) : false;
    }

    public static function check($username, $password)
    {
        $conds = array(
            'name=?' => $username,
            'password=?' => md5($password));
        $info = Sdb::fetchRow('*', self::table(), $conds);
        return $info ? new self($info) : false;
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
