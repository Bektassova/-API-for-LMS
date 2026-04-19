<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$comment = new Comment($db);

$data = json_decode(file_get_contents("php://input"));

// check if data is missing
if(!$data || !isset($data->id, $data->comment, $data->userid, $data->postid)){
    http_response_code(400);
    echo json_encode(array("message" => "Missing required fields: id, comment, userid, postid"));
    exit;
}

$comment->id = $data->id;
$comment->comment = $data->comment;
$comment->userid = $data->userid;
$comment->postid = $data->postid;

if($comment->update()){
    http_response_code(200);
    echo json_encode(array("message" => "Comment updated."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Comment not updated."));
}
?>