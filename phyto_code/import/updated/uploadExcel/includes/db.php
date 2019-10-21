<?php

class Db {
    protected static $db;

    public function connect() {
        if(!isset(self::$db)) {
            $config = parse_ini_file('config/config.ini');
            self::$db = new mysqli($config['database']['address'],
            					   $config['database']['username'],
            					   $config['database']['password'],
            					   $config['database']['name'],
            					   $config['database']['port']);
        }

        if(self::$db === false) {
            return false;
        }
        return self::$db;
    }

    public function query($query) {
        $db = $this -> connect();
        $result = $db -> query($query);

        return $result;
    }

    public function select($query) {
        $rows = array();
        $result = $this -> query($query);
        if($result === false) {
            return false;
        }
        while ($row = $result -> fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function error() {
        $db = $this->connect();
        return $db->error;
    }

    public function quote($value) {
        $db = $this -> connect();
        return "'" . $db -> real_escape_string($value) . "'";
    }
}
