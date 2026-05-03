<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");

header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");


include_once("../../includes/initialize.php");

// Create a new instance of the Comment class
// This allows us to use its structure and functions
$comment = new Comment($db);

$result = $comment->read();
$num = $result->rowCount();

if($num > 0){
    $comments_list = array();
    $comments_list['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $comment_item = array(
            "id"        => $id,
            "comment"   => $comment,
            "userId"    => $userId,
            "postId"    => $postId,
        );

        array_push($comments_list['data'], $comment_item);
    }

    echo json_encode($comments_list);
}
else{
    echo json_encode(array("message"=>"No comments found."));
}


?>