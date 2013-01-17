<?php

/**
* Former Pdb is heavy, because it has to be compatiable with former files
* and then, I have not been useing Modle layer
* Now since I have used ORM, it's better to write a more light Sql Db class
*/
class Sdb
{
    private static $db = null;
    private static $config = null;
    private static $log = array();

    public static function setConfig($config = array())
    {
        $defaultConfig = array(
            'host' => 'localhost',
            'username' => 'root',
        );
        $config = array_merge($defaultConfig, $config);

        // username and password
        $username = $config['username'];
        $password = $config['password'];

        // then look for master or slave or no
        if (isset($config['host'])) {
            $conf['host'] = $config['host'];
        }
        if (isset($config['port'])) {
            $conf['port'] = $config['port'];
        }
        if (isset($config['dbname'])) {
            $conf['dbname'] = $config['dbname'];
        }
        if (isset($config['master'])) {
            $master = array_merge($conf, $config['master']);
        } else {
            $master = $conf;
        }
        if (isset($config['slave'])) {
            $slave = array_merge($conf, $config['slave']);
        } else {
            $slave = $conf;
        }
        $dsn = self::makeDsn($master);
        $dsn_s = self::makeDsn($slave);

        $config = compact('dsn', 'dsn_s', 'username', 'password');
        self::$config = $config;

    }

    private static function makeDsn($arg) 
    {
        $arr = array();
        foreach ($arg as $key => $value) {
            $arr[] = $key . '=' . $value;
        }
        return 'mysql:' . implode(';', $arr);
    }

    public static function getDb()
    {
        if (self::$db !== null)
            return self::$db;
        $config = self::$config;
        return self::$db =  new PDO($config['dsn'], $config['username'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
    }

    // $conds : string
    // $conds : string => [para,...]
    public static function fetch($fields, $tables, $conds = '', $orderbys = array(), $tail = '')
    {
        if (is_array($fields))
            $fields = implode(',', $fields);
        if (is_array($tables))
            $tables = implode(',', $tables);
        if (is_array($conds)) {
            $paras = reset($conds);
            $conds = reset(array_keys($conds));
        }
        $orderby = implode(',', $orderbys);

        $whereStr = $conds ? "WHERE $conds" : '';
        $orderStr = $orderby ? "ORDER BY $orderby" : '';
        $sql = "SELECT $fields FROM $tables $whereStr $orderStr $tail";

        $db = self::getDb();
        $s = $db->prepare($sql);
        if (isset($paras)) {
            if (!is_array($paras))
                $paras = array($paras);
            $i = 0;
            foreach ($paras as $value) {
                $i++;
                $s->bindValue($i, $value);
            }
        }
        if (!$s->execute()) {
            d($s->errorInfo());
            throw new Exception("db execute error", 1);
        }

        self::addLog($sql, isset($paras) ? $paras : null);
        
        $ret = array();
        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
            if (count($row) == 1) {
                $row = reset($row);
            }
            $ret[] = $row;
        }
        return $ret;
    }

    public static function fetchRow($fields, $tables, $conds = '', $orderbys = array(), $tail = '')
    {
        $arr = self::fetch($fields, $tables, $conds, $orderbys, $tail . ' LIMIT 1');
        return $arr ? reset($arr) : false;
    }

    public static function insert($data, $table, $tail='') {
        $dataStr = reset(array_keys($data));
        $bindValues = reset($data);

        $sql = "INSERT INTO $table SET $dataStr $tail";
        $db = self::getDb();
        $s = $db->prepare($sql);
        $i = 0;
        foreach ($bindValues as $value) {
            $i++;
            $s->bindValue($i, $value);
        }
        if (!$s->execute()) {
            throw new Exception(end($s->errorInfo()));
        }
    }

    public static function lastInsertId() {
        $db = self::getDb();
        return $db->lastInsertId();
    }

    public static function update($data, $table, $conds = null, $tail = '') {

        $db = self::getDb();
        $dataStr = reset(array_keys($data));
        $bindValues = reset($data);

        if (is_array($conds)) {
            $p = reset($conds); // para or list of para
            $conds = reset(array_keys($conds));
            if (is_array($p)) {
                $bindValues = array_merge($bindValues, $p);
            } else {
                $bindValues[] = $p;
            }
        }

        $where = $conds? "WHERE $conds" : '';
        $sql = "UPDATE $table SET $dataStr $where $tail";
        $s = $db->prepare($sql);
        $i = 0;
        foreach ($bindValues as $value) {
            $i++;
            $s->bindValue($i, $value);
        }
        if (!$s->execute()) {
            throw new Exception(end($s->errorInfo()));
        }

        self::addLog($sql, $bindValues);
    }

    public static function delete($table, $conds) {
        if (is_array($conds)) {
            $p = reset($conds); // para or list of para
            $conds = reset(array_keys($conds));
            if (is_array($p)) {
                $bindValues = $p;
            } else {
                $bindValues = array($p);
            }
        }

        $where = $conds ? "WHERE $conds" : '';
        $sql = "DELETE FROM $table $where";
        $db = self::getDb();
        $s = $db->prepare($sql);

        $i = 0;
        foreach ($bindValues as $value) {
            $i++;
            $s->bindValue($i, $value);
        }
        if (!$s->execute()) {
            throw new Exception(end($s->errorInfo()));
        }
    }

    private static function addLog($sql, $paras = null)
    {
        if ($paras) {
            $sql = array('sql' => $sql, 'paras' => $paras);
        }
        self::$log[] = $sql;
    }

    public static function log()
    {
        return self::$log;
    }
}
