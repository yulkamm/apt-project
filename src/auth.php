<?php
// Защита от повторного выполнения
if (defined('AUTH_INCLUDED')) {
    return;
}
define('AUTH_INCLUDED', true);

// session_start() ТОЛЬКО если не начата
if (session_status() === PHP_SESSION_NONE) {
    if (!headers_sent()) {
        session_start();
    }
}

// Подключение config.php
if (!defined('DB_HOST')) {
    $configPaths = [__DIR__ . '/config.php', __DIR__ . '/../config.php'];
    foreach ($configPaths as $path) {
        if (file_exists($path)) {
            include $path;
            break;
        }
    }
}

// Функции авторизации
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header('Location: index.php');
        exit;
    }
}

function registerUser($username, $email, $password, $fullName) {
    global $conn;
    if (!$conn) return ['success' => false, 'message' => 'Нет подключения к БД'];
    
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $fullName = mysqli_real_escape_string($conn, $fullName);
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password, full_name, role) 
            VALUES ('$username', '$email', '$passwordHash', '$fullName', 'user')";
    
    if ($conn->query($sql)) {
        return ['success' => true, 'message' => 'Регистрация успешна!'];
    }
    return ['success' => false, 'message' => 'Ошибка: ' . $conn->error];
}

function loginUser($username, $password) {
    global $conn;
    if (!$conn) return ['success' => false, 'message' => 'Нет подключения к БД'];
    
    $username = mysqli_real_escape_string($conn, $username);
    $result = $conn->query("SELECT * FROM users WHERE username = '$username' OR email = '$username'");
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            $conn->query("UPDATE users SET last_login = NOW() WHERE id = {$user['id']}");
            return ['success' => true, 'user' => $user];
        }
    }
    return ['success' => false, 'message' => 'Неверное имя пользователя или пароль'];
}
?>