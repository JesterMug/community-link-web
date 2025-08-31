<?php

$db_hostname = "localhost";
$db_username = "fit2104";
$db_password = "xuxxur-ziWpaf-5busmi";
$db_name = "fit2104_community_link";

try {
    $dsn = "mysql:host=$db_hostname;dbname=$db_name;charset=utf8mb4";
    $pdo = new PDO($dsn, $db_username, $db_password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

return $pdo;