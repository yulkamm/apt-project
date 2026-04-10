<?php
// Защита от повторного подключения
if (defined('DB_HOST')) {
    return;
}

// Переменные окружения от Railway
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'aptuser');
define('DB_PASS', getenv('DB_PASS') ?: 'aptpass123');
define('DB_NAME', getenv('DB_NAME') ?: 'apt_database');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    error_log("DB Error: " . $conn->connect_error);
    die("Ошибка подключения к базе данных");
}

$conn->set_charset("utf8mb4");
$conn->query("SET NAMES 'utf8mb4'");
?>