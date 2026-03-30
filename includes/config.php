<?php
$db_user= "root";
$db_password='root';
$db_name= "ERD_exercise";


$db= new PDO("mysql:host=localhost;dbname=".$db_name."; charset=utf8",
$db_user,
$db_password);

$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>