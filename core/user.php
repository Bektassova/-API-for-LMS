<?php

class User {
private $conn;
private $table ="user";
private $alias ="u";


public$id;
public$username;
public$firstName;
public$lastName;
public$age;


// constructor -> db connection
public function __construct($db) {

$this->conn = $db;
}

public function read (){
    $query = "SELECT * FROM {$this->table }  AS {$this->alias} 
    ORDER BY  {$this->alias}.username ASC;";
$stmt = $this->conn-> prepare ($query);
$stmt->execute();
return $stmt;
}
}
?>