<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PATCH");

header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");


include_once("../../includes/initialize.php");

// Create a new instance of the User class
// This allows us to use its structure and functions
$user = new User($db);

// read submitted json data from request body 
$data = json_decode(file_get_contents("php://input"));

// fill in user instance properties with decoded values from request
$user->id = $data->id;
$user->age = $data->age;

if($user->updateAge()){
    echo json_encode(array("message" => "User Age updated."));
}
else{
    echo json_encode(array("message" => "User Age not updated."));
}


