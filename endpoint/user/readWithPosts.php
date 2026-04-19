<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../includes/initialize.php");

$user = new User($db);
$post = new Post($db);

$result = $user->read();
$rows = $result->fetchAll(PDO::FETCH_ASSOC);

if(count($rows) > 0){
    $users_list = array();
    $users_list['data'] = array();

    foreach($rows as $row){

        $post->userId = $row["id"];
        $postsResult = $post->readByUserId();

        $postsList = array();

        while($postRow = $postsResult->fetch(PDO::FETCH_ASSOC)){
            $post_item = array(
                "id"        => $postRow["id"],
                "title"     => $postRow["title"],
                "content"   => $postRow["content"],
                "userId"    => $postRow["userid"],
            );
            array_push($postsList, $post_item);
        }

        $user_item = array(
            "id"        => $row["id"],
            "username"  => $row["username"],
            "firstName" => $row["firstName"],
            "lastName"  => $row["lastName"],
            "age"       => $row["age"],
            "posts"     => $postsList
        );

        array_push($users_list['data'], $user_item);
    }

    echo json_encode($users_list);
} else {
    echo json_encode(array("message" => "No users found."));
}
?>