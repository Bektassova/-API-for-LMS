<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$comment = new Comment($db);

$data = json_decode(file_get_contents("php://input"));

$comment->id = $data->id;
$comment->comment = $data->comment;
$comment->userid = $data->userid;
$comment->postid = $data->postid;

if($comment->update()){
    echo json_encode(array("message" => "Comment updated."));
} else {
    echo json_encode(array("message" => "Comment not updated."));
}
?>