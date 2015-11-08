<?php

namespace Aleladen\Lib;


final class Database {

    private static $instance;

    private function __construct($db_datasource, $db_user, $db_pass, $db_option = array()) {
        self::$instance = new \PDO($db_datasource, $db_user, $db_pass, $db_option);
    }
    
    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new Database(DB_DATASOURCE, DB_USER, DB_PASS);            
        }
        return self::$instance;
    }
    
    private function __clone() {}
    
    private function __wakeup() {}
    
    
}