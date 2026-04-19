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
    public $userid;

    // constructor with db connection
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
        if($row){
            $this->title  = $row["title"];
            $this->content = $row["content"];
            $this->userid = $row["userid"];
        }

        return $stmt;
    }

    // Read all Post records by a single User
    public function readByUserId(){
        $query = "SELECT * 
                    FROM {$this->table} AS {$this->alias}
                    WHERE {$this->alias}.userid = ?
                    ORDER BY {$this->alias}.id DESC;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->userid);
        $stmt->execute();

        return $stmt;
    }

    // Create a new Post record
    public function create(){
        $query = "INSERT INTO {$this->table}
                    (title, content, userid)
                    VALUES (:title,:content,:userid);";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->userid = htmlspecialchars(strip_tags($this->userid));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":userid", $this->userid);

        if($stmt->execute()){
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
                        userid = :userid
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->userid = htmlspecialchars(strip_tags($this->userid));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":userid", $this->userid);

        if($stmt->execute()){
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // Update userid of a Post record
    public function updateUserId(){
        $query = "UPDATE {$this->table}
                    SET userid = :userid
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->userid = htmlspecialchars(strip_tags($this->userid));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":userid", $this->userid);

        if($stmt->execute()){
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // Update only content of a Post record
    public function updateContent(){
        $query = "UPDATE {$this->table}
                    SET content = :content
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->content = htmlspecialchars(strip_tags($this->content));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":content", $this->content);

        if($stmt->execute()){
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

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

}

?>