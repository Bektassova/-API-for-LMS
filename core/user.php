<?php

class User{

    // db related properties
    private $conn;
    private $table = "user";
    private $alias = "u";

    // table fields 
    public $id;
    public $username;
    public $firstName;
    public $lastName;
    public $age;

    // constructor with db connection
    // a function that is triggered automatically when an instance of the class is created
    public function __construct($db){
        $this->conn = $db;
    }

    // Read all User records
    public function read(){
        $query = "SELECT * 
                    FROM {$this->table} AS {$this->alias} 
                    ORDER BY {$this->alias}.username ASC;";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // Read a single User record by id
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
            $this->username     = $row["username"];
            $this->firstName    = $row["firstName"];
            $this->lastName     = $row["lastName"];
            $this->age          = $row["age"];
        }

        return $stmt;
    }

    // Create a new User record 
    public function create(){
        $query = "INSERT INTO {$this->table}
                    (username, firstName, lastName, age)
                    VALUES (:username,:firstName,:lastName,:age);";

        $stmt = $this->conn->prepare($query);

        // clean up data sent by user/3rd party system (for security)
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->age = htmlspecialchars(strip_tags($this->age));

        // bind parameters to sql statement
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":firstName", $this->firstName);
        $stmt->bindParam(":lastName", $this->lastName);
        $stmt->bindParam(":age", $this->age);

        if($stmt->execute())
        {
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // Update a User record
    public function update(){
        $query = "UPDATE {$this->table}
                    SET username = :username,
                        firstName = :firstName,
                        lastName = :lastName,
                        age = :age
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        // clean up data sent by user/3rd party system (for security)
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->age = htmlspecialchars(strip_tags($this->age));

        // bind parameters to sql statement
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":firstName", $this->firstName);
        $stmt->bindParam(":lastName", $this->lastName);
        $stmt->bindParam(":age", $this->age);

        if($stmt->execute())
        {
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

// Update Age of a User record
    public function updateAge(){
        $query = "UPDATE {$this->table}
                    SET age = :age
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        // clean up data sent by user/3rd party system (for security)
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->age = htmlspecialchars(strip_tags($this->age));

        // bind parameters to sql statement
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":age", $this->age);

        if($stmt->execute())
        {
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

 // Delete a User record
public function delete(){
    $query = "DELETE FROM {$this->table}
                WHERE id = :id;";

    $stmt = $this->conn->prepare($query);

    // clean up
    $this->id = htmlspecialchars(strip_tags($this->id));

    // bind only id
    $stmt->bindParam(":id", $this->id);

    if($stmt->execute()){
        return true;
    }

    printf("Error %s. \n", $stmt->error);
    return false;
}
}

?>