<?php

namespace PHP_REST_API;

use PDO;

class Category
{
    // Database connection and table name.
    private $conn;
    private $table = 'categories';

    // Category Properties
    public $id;
    public $name;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Categories
    public function read()
    {
        //Query
        $query = "SELECT * FROM $this->table ORDER BY id ASC";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute Query
        $stmt->execute();

        return $stmt;
    }

    // Get a single category
    public function readSingle()
    {
        // Create Query
        $query = "SELECT * FROM $this->table WHERE id = :id LIMIT 0,1";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->name = $row['name'];
        $this->created_at = $row['created_at'];

        return $stmt;
    }

    // Create Category
    public function create()
    {
        // Create th Insert Query
        $query = "INSERT INTO $this->table SET name = :name";

        $stmt = $this->conn->prepare($query);

        // Clean up
        $this->name = htmlspecialchars(strip_tags($this->name));

        //Bind
        $stmt->bindParam(':name', $this->name);

        // Execute Query
        if ($stmt->execute()) {
            return true;
        }
        // Print error if failed
        printf('Error: %s.\n', $stmt->error);
        return false;
    }
}
