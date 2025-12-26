<?php
require_once __DIR__ . '/../config/config.php';


class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $config = Config::database();

        try {
            $this->connection = new PDO(
                "mysql:host={$config['host']};
                dbname={$config['dbName']};
                charset=utf8",$config['username'],
                $config['password']
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
