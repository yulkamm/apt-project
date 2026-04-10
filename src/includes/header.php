<?php
// Защита от повторного выполнения
if (defined('HEADER_INCLUDED')) {
    return;
}
define('HEADER_INCLUDED', true);

// Подключение auth.php только если функции не определены
if (!function_exists('isLoggedIn')) {
    $authPaths = [
        __DIR__ . '/../auth.php',
        __DIR__ . '/auth.php',
        __DIR__ . '/../../auth.php'
    ];
    foreach ($authPaths as $path) {
        if (file_exists($path)) {
            include $path;
            break;
        }
    }
}
?>
<nav class="navbar">
    <div class="container">
        <div class="logo">АПТ</div>
        <ul class="nav-links">
            <li><a href="index.php">Главная</a></li>
            <li><a href="about.php">О нас</a></li>
            <li><a href="contacts.php">Контакты</a></li>
            <li><a href="students.php">Студенты</a></li>
            <li><a href="teachers.php">Преподаватели</a></li>
            
            <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
                <?php if (function_exists('isAdmin') && isAdmin()): ?>
                    <li><a href="admin_students.php" class="admin-link">👤 Студенты (админ)</a></li>
                    <li><a href="admin_teachers.php" class="admin-link">👨‍🏫 Преподаватели (админ)</a></li>
                <?php endif; ?>
                <li><a href="profile.php">👤 <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></a></li>
                <li><a href="logout.php" class="btn-logout">🚪 Выход</a></li>
            <?php else: ?>
                <li><a href="register.php" class="btn-register">📝 Регистрация</a></li>
                <li><a href="login.php" class="btn-login">🔐 Вход</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>