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
if (!function_exists('registerUser')) {
    if (file_exists(__DIR__ . '/auth.php')) {
        include __DIR__ . '/auth.php';
    }
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($fullName) || empty($username) || empty($email) || empty($password)) {
        $error = 'Заполните все обязательные поля';
    } elseif ($password !== $confirmPassword) {
        $error = 'Пароли не совпадают';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен быть не менее 6 символов';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Введите корректный email адрес';
    } elseif (strlen($username) < 3) {
        $error = 'Имя пользователя должно быть не менее 3 символов';
    } else {
        $result = registerUser($username, $email, $password, $fullName);
        
        if ($result['success']) {
            $message = '✅ Регистрация успешна! Теперь вы можете войти.';
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - АПТ</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Подключаем header.php ПОСЛЕ всей логики -->
<?php include 'includes/header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Регистрация</h1>
        <p>Создайте аккаунт для доступа к личному кабинету</p>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="auth-form">
            <?php if ($message): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="full_name">
                        <i class="fas fa-user-tag"></i> ФИО *
                    </label>
                    <input type="text" id="full_name" name="full_name" required placeholder="Иванов Иван Иванович" value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i> Имя пользователя *
                    </label>
                    <input type="text" id="username" name="username" required placeholder="username" minlength="3" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email *
                    </label>
                    <input type="email" id="email" name="email" required placeholder="email@example.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Пароль *
                    </label>
                    <input type="password" id="password" name="password" required placeholder="Минимум 6 символов" minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">
                        <i class="fas fa-lock"></i> Подтверждение пароля *
                    </label>
                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="Повторите пароль">
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus"></i> Зарегистрироваться
                </button>
            </form>
            
            <div class="auth-info">
                <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
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