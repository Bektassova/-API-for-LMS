<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");

include_once("../../includes/initialize.php");

$user = new User($db);
$result = $user->read();

$users_list = array();
$users_list['data'] = array();

while($row = $result->fetch(PDO::FETCH_ASSOC)){
    $user_item = array(
        'id' => $row['id'],
        'username' => $row['username'],
        'firstName' => $row['firstName'],
        'lastName' => $row['lastName'],
        'age' => $row['age']
    );
    array_push($users_list['data'], $user_item);
}

if(count($users_list['data']) > 0){
    echo json_encode($users_list);
}else{
    echo json_encode(array('message' => 'No users found.'));
}
?>







?>