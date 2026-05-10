<?php
// models/Database.php

class Database {
    private static $instance = null;
    private $pdo;

    private $host = 'localhost';
    private $dbname = 'hotel_DB';
    private $username = 'root';
    private $password = ''; // Default XAMPP password is empty

    private function __construct() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("ERROR: Could not connect to database. " . $e->getMessage());
        }
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserializing
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>
