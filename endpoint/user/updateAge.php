<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PATCH");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

// check if data is missing
if(!$data || !isset($data->id, $data->age)){
    http_response_code(400);
    echo json_encode(array("message" => "Missing required fields: id, age"));
    exit;
}

$user->id = $data->id;
$user->age = $data->age;

if($user->updateAge()){
    http_response_code(200);
    echo json_encode(array("message" => "User Age updated."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "User Age not updated."));
}
?>