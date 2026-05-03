<?php
// Заголовки для работы API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// 1. Подключаем настройки из папки includes
include_once __DIR__ . '/../../includes/config.php';

// 2. Проверяем подключение
if (!isset($db)) {
    die(json_encode(["message" => "Connection variable db not found"]));
}

// УДАЛЕНО: $database = new Database(); 
// УДАЛЕНО: $db = $database->getConnection(); 
// Переменная $db уже создана в файле config.php и готова к работе!

// 1. Получаем все посты
$query = "SELECT id, title, content, userid FROM post ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->execute();

$posts_arr = array();
$posts_arr["data"] = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $post_id = $row['id'];
    
    // Создаем структуру поста
    $post_item = array(
        "id" => $post_id,
        "title" => $row['title'],
        "content" => $row['content'],
        "userid" => $row['userid'],
        "comments" => array() 
    );

    // 2. Для каждого поста ищем его комментарии
    // ВНИМАНИЕ: в твоей базе колонка называется 'comment' или 'content'? Проверь это.
    $comment_query = "SELECT id, comment, userid FROM comment WHERE postid = ?";
    $comment_stmt = $db->prepare($comment_query);
    $comment_stmt->execute([$post_id]);

    while ($comment_row = $comment_stmt->fetch(PDO::FETCH_ASSOC)) {
        $comment_item = array(
            "id" => $comment_row['id'],
            "comment" => $comment_row['comment'], // Добавь эти строки, чтобы комментарии не были пустыми
            "userid" => $comment_row['userid']
        );
        array_push($post_item["comments"], $comment_item);
    }

    array_push($posts_arr["data"], $post_item);
}

http_response_code(200);
echo json_encode($posts_arr);
?>