<?php
// database connection (PDO)
// change these if your local mysql user/password is different

$db_host = '127.0.0.1';
$db_name = 'online_food_blog';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    // dont show details in production, but ok for class project
    die('DB connection failed: ' . $e->getMessage());
}
