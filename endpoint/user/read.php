<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$comment = new Comment($db);  // ← Comment, not User
$result = $comment->read();   // ← needs read() method in Comment class

$comments_list = array();
$comments_list['data'] = array();

while($row = $result->fetch(PDO::FETCH_ASSOC)){
    $comment_item = array(
        'id'      => $row['id'],
       'content' => $row['comment'],
        'userid'  => $row['userid'],
        'postid'  => $row['postid']
    );
    array_push($comments_list['data'], $comment_item);
}

if(count($comments_list['data']) > 0){
    http_response_code(200);
    echo json_encode($comments_list);
} else {
    http_response_code(404);
    echo json_encode(array('message' => 'No comments found.'));
}
?>