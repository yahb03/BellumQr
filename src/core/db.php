<?php

namespace YourNamespace\Core;

use mysqli;

class DB
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $config = require_once __DIR__ . '/../../config/database.php';
        $this->conn = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}