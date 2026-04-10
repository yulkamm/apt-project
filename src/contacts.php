<?php 
// PHP должен быть ПЕРВЫМ, до любого HTML!
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты - Ангарский политехнический техникум</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="page-header">
    <div class="container">
        <h1>Контакты</h1>
    </div>
</section>

<section class="content">
    <div class="container">
        <h2>Наши сотрудники</h2>
        <div class="photo-grid">
            <div class="photo-item">
                <img src="uploads/contacts/contact_1.jpg" alt="Приемная комиссия">
                <div class="photo-caption">Приемная комиссия</div>
            </div>
            <div class="photo-item">
                <img src="uploads/contacts/contact_2.jpg" alt="Учебный отдел">
                <div class="photo-caption">Учебный отдел</div>
            </div>
            <div class="photo-item">
                <img src="uploads/contacts/contact_3.jpg" alt="Методический отдел">
                <div class="photo-caption">Методический отдел</div>
            </div>
            <div class="photo-item">
                <img src="uploads/contacts/contact_4.jpg" alt="Библиотека">
                <div class="photo-caption">Библиотека</div>
            </div>
            <div class="photo-item">
                <img src="uploads/contacts/contact_5.jpg" alt="Бухгалтерия">
                <div class="photo-caption">Бухгалтерия</div>
            </div>
            <div class="photo-item">
                <img src="uploads/contacts/contact_6.jpg" alt="Отдел кадров">
                <div class="photo-caption">Отдел кадров</div>
            </div>
        </div>

        <h2 style="margin-top: 40px;">Наше местоположение</h2>
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.3!2d103.8833!3d52.5333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTLCsDMyJzAwLjAiTiAxMDPCsDUzJzAwLjAiRQ!5e0!3m2!1sru!2sru!4v1234567890"
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>

        <div class="contact-info">
            <h2>Контактная информация</h2>
            <p><strong>📍 Адрес:</strong> 665830, Иркутская область, г. Ангарск, кв-л 123, д. 45</p>
            <p><strong>📞 Телефон:</strong> +7 (3955) 12-34-56</p>
            <p><strong>📠 Факс:</strong> +7 (3955) 12-34-57</p>
            <p><strong>📧 Email:</strong> info@apt.ru</p>
            <p><strong>🌐 Сайт:</strong> www.apt.ru</p>
            <p><strong>🕐 Режим работы:</strong> Пн-Пт: 8:00 - 17:00, Сб-Вс: выходной</p>
            <p><strong>🚇 Транспорт:</strong> Остановка "Политехнический техникум", автобусы № 15, 23, 45</p>
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