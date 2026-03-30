<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$user = new User($db);

$user->id = isset($_GET["id"]) ? $_GET["id"] : die();

$user->readSingle();

if($user->username){
    $user_info = array(
        'id' => $user->id,
        'username' => $user->username,
        'firstName' => $user->firstName,
        'lastName' => $user->lastName,
        'age' => $user->age,
    );
    echo json_encode($user_info);
} else {
    echo json_encode(array("message" => "No users found."));
}
?>