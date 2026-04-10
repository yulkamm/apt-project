<?php 
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ангарский политехнический техникум - Главная</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="hero">
    <div class="container">
        <h1>Ангарский политехнический техникум</h1>
        <p>Современное образование для успешного будущего! Готовим профессионалов для промышленности и технологий.</p>
    </div>
</header>

<section class="gallery">
    <div class="container">
        <h2>Наш техникум</h2>
        <div class="photo-grid">
            <div class="photo-item">
                <img src="uploads/home/home_1.jpg" alt="Главный корпус">
                <div class="photo-caption">Главный учебный корпус АПТ</div>
            </div>
            <div class="photo-item">
                <img src="uploads/home/home_2.jpg" alt="Аудитории">
                <div class="photo-caption">Современные учебные аудитории</div>
            </div>
            <div class="photo-item">
                <img src="uploads/home/home_3.jpg" alt="Лаборатории">
                <div class="photo-caption">Учебные лаборатории и мастерские</div>
            </div>
        </div>
    </div>
</section>

<section class="info">
    <div class="container">
        <div class="info-grid">
            <div class="info-card">
                <h3>🎓 Студенты</h3>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM students");
                $row = $result->fetch_assoc();
                echo "<p>" . $row['count'] . " обучающихся</p>";
                ?>
            </div>
            <div class="info-card">
                <h3>👨‍🏫 Преподаватели</h3>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM teachers");
                $row = $result->fetch_assoc();
                echo "<p>" . $row['count'] . " преподавателей</p>";
                ?>
            </div>
            <div class="info-card">
                <h3>📚 Специальности</h3>
                <p>10+ направлений подготовки</p>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <p>&copy; 2026 Ангарский политехнический техникум. Все права защищены.</p>
        <p>📞 Телефон: +7 (3955) 12-34-56 | 📧 Email: info@apt.ru</p>
    </div>
</footer>

</body>
</html>