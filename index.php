<?php
// 1. Подключаем функции
include_once 'functions.php'; 

// 2. ОБРАБОТКА ФОРМЫ (Обновленная логика POST)
if (isset($_POST['create_user'])) {
    // Собираем массив со ВСЕМИ полями, которые потребовал сервер в ошибке
    $newUserData = [
        "username"  => $_POST['username'],
        "firstName" => $_POST['firstName'],
        "lastName"  => $_POST['lastName'],
        "email"     => $_POST['email'],
        "age"       => (int)$_POST['age'] // (int) гарантирует, что возраст уйдет как число
    ];
    
    // Отправляем расширенный массив в API
    $response = callAPI("POST", "http://localhost:8888/-API-for-LMS/endpoint/user/create.php", $newUserData);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LMS Project - Dashboard</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; line-height: 1.6; color: #333; }
        .post { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 8px; background: #fff; }
        .comment { background: #f9f9f9; padding: 8px; margin: 5px 0; list-style: none; border-left: 3px solid #007bff; }
        form { background: #eef; padding: 20px; border-radius: 8px; margin-top: 40px; }
        input { padding: 10px; margin: 5px 0; width: 200px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        .alert { padding: 10px; background: #d4edda; color: #155724; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <h1>Post Feed
        Лента постов</h1>

    <?php
    // 3. ВЫВОД ПОСТОВ (Логика GET)
    $data = callAPI("GET", "http://localhost:8888/-API-for-LMS/endpoint/post/read_all.php");

    if (isset($data['data'])) {
        foreach ($data['data'] as $post) {
            echo "<div class='post'>";
            echo "<h2>" . $post['title'] . "</h2>";
            echo "<p>" . $post['content'] . "</p>";
            
            echo "<strong>Комментарии:</strong>";
            echo "<ul>";
            if (!empty($post['comments'])) {
                foreach ($post['comments'] as $comment) {
                    echo "<li class='comment'>" . $comment['comment'] . "</li>";
                }
            } else {
                echo "<li>There are no comments yet</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    }
    ?>

    //: Поиск конкретного пользователя (новое задание).
<hr>
<h3>Search User by ID</h3>
<form action="index.php" method="GET">
    <input type="number" name="search_id" placeholder="Enter User ID (e.g. 1)" required>
    <button type="submit">Find User</button>
</form>

<?php
if (isset($_GET['search_id'])) {
        $id = $_GET['search_id'];
        $userUrl = "http://localhost:8888/-API-for-LMS/endpoint/user/readSingle.php?id=" . $id;
        $singleUser = callAPI("GET", $userUrl);

        // Проверяем, в каком формате пришли данные
        $userData = null;
        if (isset($singleUser['data'])) {
            // Если данные внутри ключа 'data'
            $userData = $singleUser['data'];
        } elseif (isset($singleUser['username'])) {
            // Если данные лежат сразу в корне
            $userData = $singleUser;
        }

        if ($userData) {
            echo "<div style='background: white; padding: 15px; margin-top: 15px; border: 1px solid #b6d4fe; border-radius: 5px;'>";
            echo "<strong>Found User (ID $id):</strong><br>";
            echo "Name: " . ($userData['firstName'] ?? 'N/A') . " " . ($userData['lastName'] ?? 'N/A') . "<br>";
            echo "Email: " . ($userData['email'] ?? 'N/A') . "<br>";
            echo "Username: " . ($userData['username'] ?? 'N/A');
            echo "</div>";
        } else {
            echo "<p style='color: red; margin-top: 15px;'>User with ID $id not found in API response.</p>";
            // Маленькая подсказка для тебя, чтобы понять, что прислал API:
            echo "<pre style='font-size:10px; color:gray;'>" . print_r($singleUser, true) . "</pre>";
        }
    }
?>
//END 

    <!-- 4. ФОРМА СОЗДАНИЯ ПОЛЬЗОВАТЕЛЯ -->
    <hr>
    <div id="create-user-section">
        <h3>Create new user</h3>
        
        <?php if (isset($response)): ?>
            <div class="alert">
                Ответ сервера: <?php echo $response['message']; ?>
            </div>
        <?php endif; ?>

     <form action="index.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="text" name="firstName" placeholder="First Name" required>
    <input type="text" name="lastName" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="number" name="age" placeholder="Age" required>
    <button type="submit" name="create_user">Register</button>
</form>
    </div>

</body>
</html>