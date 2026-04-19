<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$post = new Post($db);

// check if id is provided
if(!isset($_GET["id"])){
    http_response_code(400);
    echo json_encode(array("message" => "Missing required field: id"));
    exit;
}

$post->id = $_GET["id"];
$post->readSingle();

if($post->title){
    http_response_code(200);
    $post_info = array(
        'id'      => $post->id,
        'title'   => $post->title,
        'content' => $post->content,
        'userid'  => $post->userid,
    );
    echo json_encode($post_info);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No post found."));
}
?>