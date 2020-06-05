<?php

namespace PHP_REST_API;

use PDO;

class Post
{
    // Database Connection and info
    private $conn;
    private $table = 'posts';

    // Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Posts

    public function read()
    {
        // Create Query.
        $query = "SELECT 
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
        FROM
        $this->table p
        LEFT JOIN
        categories c ON p.category_id = c.id
        ORDER BY
        p.created_at DESC";

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get single post
    public function readSingle()
    {
        // Create Query. The ? is a positional parameter.
        $query = "SELECT 
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
        FROM
        $this->table p
        LEFT JOIN
        categories c ON p.category_id = c.id
        WHERE 
        p.id = ? 
        LIMIT 0,1";

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Bind the first postional parameter to the id.
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Set Properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];

        return $stmt;
    }

    // Create Post
    public function create()
    {
        // Create Insert Query (Uses Named params).
        $query = "INSERT INTO 
            $this->table
            SET
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id";

        $stmt = $this->conn->prepare($query);

        // CLean data before inserting
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //Bind Data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);


        //Execute Qurey
        if ($stmt->execute()) {
            return true;
        }

        //Print error if something goes wrong.
        printf('Error: %s.\n', $stmt->error);

        return false;
    }

    //Update Post
    public function update()
    {
        // Create Insert Query (Uses Named params).
        $query = "UPDATE 
            $this->table
            SET
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id
            WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // CLean data before inserting
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //Bind Data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);


        //Execute Qurey
        if ($stmt->execute()) {
            return true;
        }

        //Print error if something goes wrong.
        printf('Error: %s.\n', $stmt->error);

        return false;
    }
}