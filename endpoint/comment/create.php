<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

include_once("../../includes/initialize.php");

$comment = new Comment($db);

$data = json_decode(file_get_contents("php://input"));

if(!$data || !isset($data->comment, $data->userid, $data->postid)){
    http_response_code(400);
    echo json_encode(array("message" => "Missing required fields: comment, userid, postid"));
    exit;
}

$comment->comment = $data->comment;
$comment->userid = $data->userid;
$comment->postid = $data->postid;

if($comment->create()){
    http_response_code(201);
    echo json_encode(array("message" => "Comment created"));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Comment not created"));
}
?>