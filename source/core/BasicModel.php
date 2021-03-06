<?php

/**
 * @author ryan
 */

class BasicModel
{
    protected $id = null;
    protected $info = null;
    
    public function __construct($para)
    {
        if (is_array($para)) {
            if (isset($para['id']))
                $this->id = $para['id'];
            $this->info = $para;
        } elseif (is_numeric($para)) {
            $this->id = $para;
        } elseif (is_a($para, get_called_class())) { // clone
            $this->id = $para->id;
        } else {
            d($para);
            throw new Exception("not good arg for construct ".get_called_class());
        }
    }

    public static function create($info = array())
    {
        $exps = array_map(function ($key) {
            if (strpos($key, '=') === false)
                return "$key=?";
            else
                return $key;
        }, array_keys($info));
        $str = implode(',', $exps);
        $values = self::notNull($info);
        $values = array_map(function ($v) { // is there any where else need this transaction? update? find?
            if (is_object($v) && is_a($v, 'BasicModel')) {
                return $v->id;
            } else {
                return $v;
            }
        }, $values);

        $data = array($str => $values);

        $self = get_called_class();
        Sdb::insert($data, self::table());
        return new $self(Sdb::lastInsertId());
    }

    public static function notNull($info)
    {
        return array_filter(array_values($info), function ($e) {
            return ($e !== null && $e !== false);
        });
    }

    public function toArray()
    {
        return $this->info();
    }

    protected function info() // will this bug?
    {
        $self = get_called_class();
        $ret = Sdb::fetchRow('*', $self::table(), $this->selfCond());
        if (empty($ret))
            throw new Exception(get_called_class() . " no id: $this->id");
        $this->info = $ret;
        return $ret;
    }

    public function exists()
    {
        return false !== Sdb::fetchRow('id', static::table(), $this->selfCond());
    }

    public function selfCond()
    {
        return array('id = ?' => $this->id);
    }

    public static function table()
    {
        $self = get_called_class();
        if (isset($self::$table))
            return $self::$table;
        else 
            return camel2under($self); // camal to underscore
    }

    public function update($a, $value = null)
    {
        if($value !== null) { // given by key => value
            $data = array("$a=?" => $value);
        } else {
            $exps = array_map(function ($key) {
                if (strpos($key, '=') === false)
                    return "$key=?";
                else
                    return $key;
            }, array_keys($a));
            $str = implode(',', $exps);
            $values = self::notNull($a);
            $data = array($str => $values);
        }
        Sdb::update($data, self::table(), $this->selfCond()); // why we need that? that doesn't make any sense
        $this->info = $this->info(); // refresh data. ineffitioncy!!!
    }

    public function __get($name) 
    {
        if ($name === 'id') return $this->id;
        if (empty($this->info))
            $this->info = $this->info();
        $info = $this->info;
        if ($info === false) {
            throw new Exception("info empty, maybe because you have no id: $this->id in " . get_called_class());
        }
        if (!array_key_exists($name, $info)) {
            d($info);
            throw new Exception("no '$name' when get in class " . get_called_class());
        }
        return $info[$name];
    }

    public function __call($name, $args)
    {
        if (!($this->info))
            $this->info = $this->info();
        $info = $this->info;
        $prop = camel2under($name);
        if (isset($info[$prop])) {
            $class = ucfirst($name);
            return new $class($info[$prop]);
        } else {
            throw new Exception("no $prop when call $name", 1);
        }
    }

    public function del()
    {
        Sdb::delete(self::table(), $this->selfCond());
    }

    public static function search()
    {
        return new Searcher(get_called_class());
    }

    public static function relationMap()
    {
        $self = get_called_class();
        return isset($self::$relationMap) ? $self::$relationMap : array();
    }
}
