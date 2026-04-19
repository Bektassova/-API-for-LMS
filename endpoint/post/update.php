<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

// check if data is missing
if(!$data || !isset($data->id, $data->title, $data->content, $data->userid)){
    http_response_code(400);
    echo json_encode(array("message" => "Missing required fields: id, title, content, userid"));
    exit;
}

$post->id = $data->id;
$post->title = $data->title;
$post->content = $data->content;
$post->userid = $data->userid;

if($post->update()){
    http_response_code(200);
    echo json_encode(array("message" => "Post updated."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Post not updated."));
}
?>