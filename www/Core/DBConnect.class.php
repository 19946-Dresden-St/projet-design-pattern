<?php 
namespace App\Core;

class DBConnect{

    private static $instance = null;
    public $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new \PDO(
              DBDRIVER . ":host=" . DBHOST . ";port=" . DBPORT . ";dbname=" . DBNAME, DBUSER,DBPWD,[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]
            );
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new DbConnect();
        }
        return self::$instance;
    }

}

