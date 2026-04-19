<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$user = new User($db);

// read submitted json data from request body
$data = json_decode(file_get_contents("php://input"));

// check if data is missing
if(!$data || !isset($data->username, $data->firstName, $data->lastName, $data->age)){
    http_response_code(400);
    echo json_encode(array("message" => "Missing required fields: username, firstName, lastName, age"));
    exit;
}

// fill in user instance properties with decoded values from request
$user->username = $data->username;
$user->firstName = $data->firstName;
$user->lastName = $data->lastName;
$user->age = $data->age;

if($user->create()){
    http_response_code(201);
    echo json_encode(array("message" => "User created."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "User not created."));
}
?>