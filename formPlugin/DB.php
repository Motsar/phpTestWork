<?php
include('config.php');

class DB
{

    /*
     * database connection with singleton pattern
     * Declare a instance and pdo for connection
    */

    private static $_instance;
    public $pdo;

    //Stop from cloning instance

    public function __clone()
    {
        return false;
    }
    public function __wakeup()
    {
        return false;
    }

    //Use constructor to create a new pdo connection

    private function __construct()
    {

        //Insert connection data, replace <placeholder>

        $this->pdo = new PDO('mysql:host=<host>;dbname=<databaseName>stargazing', "<User>", "<Password>");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //Getter for connection class instance

    public static function getConnection()
    {
        if (self::$_instance === null) //don't check connection, check instance
        {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
}
