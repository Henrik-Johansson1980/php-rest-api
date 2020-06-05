<?php

/**
 * Database Class
 */

namespace PHP_REST_API;

use PDO;

class Database
{
    // Database Parameters
    private $host = 'localhost';
    private $db_name = 'rest_api_blog';
    private $username = 'root';
    private $password = '';
    private $conn;

    // DB Connect
    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
