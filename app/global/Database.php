<?php

/**
 * Class Database
 */
class Database
{
    /**
     * @var
     */
    public static $instance;

    /**
     * @var
     */
    public static $instanceMysql;

    /**
     * @return PDO
     */
    public static function getInstance()
    {
        $hostname = DB_HOSTNAME;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $database = DB_DATABASE;

        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:host=' . $hostname . ';dbname=' . $database, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            } catch ( PDOException $e ){
                Erro::log("[DATABASE] " . $e->getMessage() , 'error');
                exit($e->getMessage());
            }
        }

        return self::$instance;
    }

    /**
     * Destrutor
     */
    public function __destruct(){
        if (isset(self::$instance)) {
            self::$instance = null;
        }
    }

    /**
     * @return MYSQLi
     */
    public static function getInstanceMysql()
    {
        $hostname = DB_HOSTNAME;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $database = DB_DATABASE;

        if (!isset(self::$instanceMysql)) {
            try {
                self::$instanceMysql = mysqli_connect($hostname, $username, $password, $database);
            } catch ( Exception $e ){
                Erro::log("[DATABASE] " . $e->getMessage() , 'error');
                exit($e->getMessage());
            }
        }

        return self::$instanceMysql;
    }
}
