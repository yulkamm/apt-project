<?php
// Защита от повторного подключения
if (defined('DB_HOST')) {
    return;
}

define('DB_HOST', 'db');
define('DB_USER', 'aptuser');
define('DB_PASS', 'aptpass123');
define('DB_NAME', 'apt_database');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    error_log("DB Error: " . $conn->connect_error);
    die("Ошибка подключения к базе данных");
}

// Установка кодировки UTF-8
$conn->set_charset("utf8mb4");
$conn->query("SET NAMES 'utf8mb4'");
$conn->query("SET CHARACTER SET 'utf8mb4'");
$conn->query("SET COLLATION_CONNECTION='utf8mb4_unicode_ci'");
?>