<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$user = new User($db);

// check if id is provided
if(!isset($_GET["id"])){
    http_response_code(400);
    echo json_encode(array("message" => "Missing required field: id"));
    exit;
}

$user->id = $_GET["id"];
$user->readSingle();

if($user->username){
    http_response_code(200);
    $user_info = array(
        'id'        => $user->id,
        'username'  => $user->username,
        'firstName' => $user->firstName,
        'lastName'  => $user->lastName,
        'age'       => $user->age,
    );
    echo json_encode($user_info);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No user found."));
}
?>