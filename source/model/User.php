<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class User extends BasicModel
{
    public static $table = 'user';

    protected function info()
    {
        return Pdb::fetchRow('*', self::$table, $this->selfCond());
    }

    public static function has($username)
    {
        return Pdb::exists(self::$table, array('name=?' => $username));
    }

    public static function check($username, $password)
    {
        return Pdb::exists(self::$table, array(
            'name=?' => $username,
            'password=?' => md5($password)));
    }

    public function checkPassword($password)
    {
        return md5($password) === $this->password;
    }

    public function getByName($username)
    {
        $cond = array('name=?' => $username);
        return new self(Pdb::fetchRow('*', self::$table, $cond));
    }

    public function changePassword($new_password)
    {
        Pdb::update(
            array('password' => md5($new_password)),
            self::$table,
            $this->selfCond());
    }

    public function login()
    {
        $_SESSION['se_user_id'] = $this->id;

        // log it
        UserLog::userLogin($this->id);
    }

    public function logout()
    {
        $_SESSION['se_user_id'] = 0;
    }

    public function instance()
    {
        switch ($this->type) {
            case 'SuperAdmin':
                return new SuperAdmin($this->id);
                break;

            case 'Admin':
                return new Admin($this->id);
                break;

            case 'Customer':
                return Customer::createFromUser($this);
                break;
                
            default:
                throw new Exception("unknown user type: $this->type");
                break;
        }
    }

    public static function loggingUser()
    {
        if (isset($_SESSION['se_user_id']) && $_SESSION['se_user_id']) {
            return new self($_SESSION['se_user_id']);
        } else {
            return false;
        }
    }

    // only customers can be reistered
    public static function register($kvs)
    {
        extract($kvs);
        $type = 'customer';
        Pdb::insert(
            array(
                'name' => $username,
                'password' => md5($password),
                'type' => $type,
                'realname' => $realname,
                'phone' => $phone,
                'email' => $email,
                'create_time=NOW()' => null,
            ),
            self::$table
        );
        return new self(Pdb::lastInsertId());
    }

    public function loginHistory($conds = array())
    {
        $conds = $this->loginConds();
        $order = 'id desc';
        $tail = "LIMIT 10";
        $ret = safe_array_map(function ($info) {
            $info['ip'] = $info['info'];
            return $info;
        }, Pdb::fetchAll('*', UserLog::$table, $conds, $order, $tail));
        return $ret;
    }

    public function loginTimes()
    {
        return Pdb::count(UserLog::$table, $this->loginConds());
    }

    private function loginConds()
    {
        return array(
            'subject=?' => $this->id,
            'action=?' => 'Login');
    }
}
