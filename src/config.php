<?php
// Защита от повторного подключения
if (defined('DB_HOST')) {
    return;
}

// Переменные окружения от Railway (с правильными fallback)
define('DB_HOST', getenv('DB_HOST') ?: getenv('MYSQL_HOST') ?: 'mysql.railway.internal');
define('DB_PORT', getenv('DB_PORT') ?: getenv('MYSQL_PORT') ?: '3306');
define('DB_USER', getenv('DB_USER') ?: getenv('MYSQL_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: getenv('MYSQL_PASSWORD') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: getenv('MYSQL_DATABASE') ?: 'railway');

// Подключение к БД с портом
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);

if ($conn->connect_error) {
    error_log("DB Connection Error: " . $conn->connect_error);
    error_log("DB_HOST: " . DB_HOST . ", DB_PORT: " . DB_PORT . ", DB_USER: " . DB_USER . ", DB_NAME: " . DB_NAME);
    die("Ошибка подключения к базе данных");
}

$conn->set_charset("utf8mb4");
$conn->query("SET NAMES 'utf8mb4'");
?>
