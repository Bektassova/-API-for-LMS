<?php

class Comment{

    // db related properties
    private $conn;
    private $table = "comment";
    private $alias = "c";

    // table fields
    public $id;
    public $comment;
    public $userid;
    public $postid;

    // constructor with db connection
    public function __construct($db){
        $this->conn = $db;
    }

    // create new Comment
    public function create(){
        $query = "INSERT INTO {$this->table}
                    SET
                    comment = :comment,
                    userid = :userid,
                    postid = :postid";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':comment', $this->comment);
        $stmt->bindParam(':userid', $this->userid);
        $stmt->bindParam(':postid', $this->postid);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Read a single Comment record by Id
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
            $this->comment = $row["comment"];
            $this->userid = $row["userid"];
            $this->postid = $row["postid"];
        }

        return $stmt;
    }

    // Update a Comment record
    public function update(){
        $query = "UPDATE {$this->table}
                    SET comment = :comment,
                        userid = :userid,
                        postid = :postid
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->comment = htmlspecialchars(strip_tags($this->comment));
        $this->userid = htmlspecialchars(strip_tags($this->userid));
        $this->postid = htmlspecialchars(strip_tags($this->postid));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":comment", $this->comment);
        $stmt->bindParam(":userid", $this->userid);
        $stmt->bindParam(":postid", $this->postid);

        if($stmt->execute()){
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // Update only comment text
    public function updateComment(){
        $query = "UPDATE {$this->table}
                    SET comment = :comment
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->comment = htmlspecialchars(strip_tags($this->comment));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":comment", $this->comment);

        if($stmt->execute()){
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

}

?>