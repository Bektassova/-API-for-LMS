<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Allow-Origin,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once("../../includes/initialize.php");

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

if(!$data || !isset($data->title, $data->content, $data->userid)) {
    http_response_code(400);
    echo json_encode(array("message" => "Missing required fields: title, content, userid"));
    exit;
}

$post->title = $data->title;
$post->content = $data->content;
$post->userid = $data->userid;

if($post->create()){
    http_response_code(201);
    echo json_encode(array("message" => "Post created"));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Post not created"));
}