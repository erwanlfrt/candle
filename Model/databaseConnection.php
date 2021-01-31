<?php

namespace Model;

/**
 * Database connection according to Singleton pattern.
 */
class DatabaseConnection{
    private static $instance;
    private $dbConn;

    private function __construct(){

    }

    /**
     * Get the only instance of database (singleton).
     * @return DatabaseConnection
     */
    private static function getInstance(){
        if(self::$instance == null){
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }

    /**
     * Init the database connection.
     * @return DatabaseConnection
     */
    private static function initConnection(){
        $db = self::getInstance();

        $db_username = 'erwanlfrt';
        $db_password = 'Azerty1!';
        $db_name     = 'bougie';
        $db_host     = 'localhost';

        $db->dbConn = new \mysqli($db_host, $db_username, $db_password, $db_name);
        $db->dbConn->set_charset('utf8');
        
        return $db;
    }

    /**
     * @return mysqli
     */
    public static function getDatabaseConnection(){
        try{
            $db = self::initConnection();
            return $db->dbConn;
        }
        catch(\Exception $e){
            echo "Unable to connect to database. ".$e->getMessage();
            return null;
        }
    }


}
?>