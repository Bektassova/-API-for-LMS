<?php

class Post{

    // db related properties
    private $conn;
    private $table = "post";
    private $alias = "p";

    // table fields 
    public $id;
    public $title;
    public $content;
    public $userId;

    // constructor with db connection
    // a function that is triggered automatically when an instance of the class is created
    public function __construct($db){
        $this->conn = $db;
    }

    // Read all Post records
    public function read(){
        $query = "SELECT * 
                    FROM {$this->table} AS {$this->alias} 
                    ORDER BY {$this->alias}.id DESC;";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // Read a single Post record by id
    public function readSingle(){
        $query = "SELECT * 
                    FROM {$this->table} AS {$this->alias}
                    WHERE {$this->alias}.id = ?
                    LIMIT 1;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row > 0){
            $this->title      = $row["title"];
            $this->content    = $row["content"];
            $this->userId     = $row["userId"];
        }

        return $stmt;
    }

    // Read all Post records created by a single User (based on UserId)
    public function readByUserId(){
        $query = "SELECT * 
                    FROM {$this->table} AS {$this->alias}
                    WHERE {$this->alias}.userId = ?
                    ORDER BY {$this->alias}.id DESC;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->userId);
        $stmt->execute();

        return $stmt;
    }

    // Create a new Post record 
    public function create(){
        $query = "INSERT INTO {$this->table}
                    (title, content, userId)
                    VALUES (:title,:content,:userId);";

        $stmt = $this->conn->prepare($query);

        // clean up data sent by user/3rd party system (for security)
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // bind parameters to sql statement
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":userId", $this->userId);

        if($stmt->execute())
        {
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // Update a Post record
    public function update(){
        $query = "UPDATE {$this->table}
                    SET title = :title,
                        content = :content,
                        userId = :userId
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        // clean up data sent by user/3rd party system (for security)
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // bind parameters to sql statement
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":userId", $this->userId);

        if($stmt->execute())
        {
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

// Update User ID of a Post record
    public function updateUserId(){
        $query = "UPDATE {$this->table}
                    SET userId = :userId
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        // clean up data sent by user/3rd party system (for security)
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // bind parameters to sql statement
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":userId", $this->userId);

        if($stmt->execute())
        {
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // Delete a Post record
    public function delete(){
        $query = "DELETE FROM {$this->table}
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        // clean up data sent by user/3rd party system (for security)
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind parameters to sql statement
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute())
        {
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

}

?>