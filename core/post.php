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

    // create new Post
    public function create(){
        $query = "INSERT INTO {$this->table}
                    SET
                    title = :title,
                    content = :content,
                    userid = :userid";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':userid', $this->userid);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Read all posts
    public function read(){
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read a single Post record by Id
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
            $this->title = $row["title"];
            $this->content = $row["content"];
            $this->userid = $row["userid"];
        }

        return $stmt;
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

}

?>