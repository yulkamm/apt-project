<?php
include 'includes/header.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль - Ангарский политехнический техникум</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="page-header">
    <div class="container">
        <h1>Мой профиль</h1>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="profile-card">
            <h2>
                <i class="fas fa-user-circle"></i> 
                <?php echo htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username']); ?>
            </h2>
            
            <div class="profile-info">
                <p>
                    <strong>👤 Имя пользователя:</strong> 
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </p>
                <p>
                    <strong>🎭 Роль:</strong> 
                    <?php if (isAdmin()): ?>
                        <span class="badge-admin">👑 Администратор</span>
                    <?php else: ?>
                        <span class="badge-user">👤 Пользователь</span>
                    <?php endif; ?>
                </p>
                <p>
                    <strong>📅 Вход в систему:</strong> 
                    <?php echo date('d.m.Y H:i'); ?>
                </p>
            </div>
            
            <?php if (isAdmin()): ?>
                <div class="admin-panel">
                    <h3>🔧 Панель администратора</h3>
                    <p>Вы можете добавлять, редактировать и удалять записи студентов и преподавателей.</p>
                    <div class="admin-buttons">
                        <a href="admin_students.php" class="btn-admin">
                            <i class="fas fa-user-graduate"></i> Управление студентами
                        </a>
                        <a href="admin_teachers.php" class="btn-admin">
                            <i class="fas fa-chalkboard-teacher"></i> Управление преподавателями
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="profile-actions">
                <a href="index.php" class="btn-secondary">
                    <i class="fas fa-home"></i> На главную
                </a>
                <a href="logout.php" class="btn-logout-inline">
                    <i class="fas fa-sign-out-alt"></i> Выйти
                </a>
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