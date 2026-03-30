<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");

header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");


include_once("../../includes/initialize.php");

// Create a new instance of the User class
// This allows us to use its structure and functions
$user = new User($db);

$user->id =isset($_GET["id"]) ? $_GET["id"] : die();
if($user->delete()){
    echo json_encode(array("message" => "User deleted."));
}
else{
    echo json_encode(array("message" => "User not deleted."));
}
