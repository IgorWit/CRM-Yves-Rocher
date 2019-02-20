<?php

class Database_vici_asterisk
{
    private static $dbName = 'asterisk';
    private static $dbHost = '10.110.110.14; charset=UTF8';
    private static $dbUsername = 'cron';
    private static $dbUserPassword = '1234';

    private static $cont = null;

    public function __construct()
    {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        // One connection through whole application
        if (null == self::$cont) {
            try {
                self::$cont = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}

?>
