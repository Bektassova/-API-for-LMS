<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$comment = new Comment($db);

$comment->id = isset($_GET["id"]) ? $_GET["id"] : die();

$comment->readSingle();

if($comment->comment){
    $comment_info = array(
        'id' => $comment->id,
        'comment' => $comment->comment,
        'userid' => $comment->userid,
        'postid' => $comment->postid,
    );
    echo json_encode($comment_info);
} else {
    echo json_encode(array("message" => "No comment found."));
}
?>
```

Now test in Postman **first create**:
```
POST http://localhost:8888/-API-for-LMS/endpoint/comment/create.php