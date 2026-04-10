<?php
// Сессия ДО любого include!
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Проверка авторизации ДО вывода HTML
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Подключаем auth.php для функций (но НЕ header.php!)
if (!function_exists('loginUser')) {
    if (file_exists(__DIR__ . '/auth.php')) {
        include __DIR__ . '/auth.php';
    }
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        $result = loginUser($username, $password);
        
        if ($result['success']) {
            header('Location: index.php');
            exit;
        } else {
            $error = $result['message'];
        }
    } else {
        $error = 'Заполните все поля';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в систему - АПТ</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Подключаем header.php ПОСЛЕ всей логики -->
<?php include 'includes/header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Вход в систему</h1>
        <p>Введите свои данные для входа в личный кабинет</p>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="auth-form">
            <?php if ($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i> Имя пользователя или Email
                    </label>
                    <input type="text" id="username" name="username" required placeholder="admin или yulia">
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Пароль
                    </label>
                    <input type="password" id="password" name="password" required placeholder="Ваш пароль">
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt"></i> Войти
                </button>
            </form>
            
            <div class="auth-info">
                <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <p>&copy; 2026 Ангарский политехнический техникум. Все права защищены.</p>
    </div>
</footer>

</body>
</html>