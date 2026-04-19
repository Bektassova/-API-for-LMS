<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

if($_SERVER["REQUEST_METHOD"] != "DELETE"){
    http_response_code(405);
    echo json_encode(array("message" => "Incorrect Request Method used."));
    die();
}

include_once("../../includes/initialize.php");

$comment = new Comment($db);

// check if id is provided
if(isset($_GET["id"])){
    $comment->id = $_GET["id"];
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Comment ID was not provided."));
    die();
}

if($comment->delete()){
    http_response_code(200);
    echo json_encode(array("message" => "Comment deleted."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Comment not deleted."));
}
?>