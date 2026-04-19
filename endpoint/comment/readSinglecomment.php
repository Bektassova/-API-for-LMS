<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$comment = new Comment($db);

// check if id is provided
if(!isset($_GET["id"])){
    http_response_code(400);
    echo json_encode(array("message" => "Missing required field: id"));
    exit;
}

$comment->id = $_GET["id"];
$comment->readSingle();

if($comment->comment){
    http_response_code(200);
    $comment_info = array(
        'id'      => $comment->id,
        'comment' => $comment->comment,
        'userid'  => $comment->userid,
        'postid'  => $comment->postid,
    );
    echo json_encode($comment_info);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No comment found."));
}
?>