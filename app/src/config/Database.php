<?php
class Database {
    private static $instance = null;
    private $conn;

    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;

    private function __construct() {
        $this->host = getenv('DB_HOST') ?: '127.0.0.1';
        $this->db_name = getenv('DB_DATABASE') ?: 'hotel';
        $this->username = getenv('DB_USER') ?: 'hotel';
        $this->password = getenv('DB_PASSWORD') ?: 'hotel';
        $this->port = getenv('DB_PORT') ?: 3306;

        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name, $this->port);

        if ($this->conn->connect_error) {
            throw new Exception("Connection failed: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}