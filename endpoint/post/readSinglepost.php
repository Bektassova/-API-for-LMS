<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$post = new Post($db);

$post->id = isset($_GET["id"]) ? $_GET["id"] : die();

$post->readSingle();

if($post->title){
    $post_info = array(
        'id' => $post->id,
        'title' => $post->title,
        'content' => $post->content,
        'userid' => $post->userid,
    );
    echo json_encode($post_info);
} else {
    echo json_encode(array("message" => "No post found."));
}
?>
```

Then test in Postman:
```
http://localhost:8888/-API-for-LMS/endpoint/post/readSingle.php?id=1