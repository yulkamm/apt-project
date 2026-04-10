<?php
header('Content-Type: text/html; charset=utf-8');
include 'config.php';
mysqli_set_charset($conn, "utf8mb4");

if (!isset($_GET['id'])) {
    echo '<p>Ошибка: не указан ID</p>';
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM teachers WHERE id = $id");

if ($teacher = $result->fetch_assoc()) {
    $fullName = htmlspecialchars($teacher['last_name'] . ' ' . $teacher['first_name'] . ' ' . $teacher['middle_name'], ENT_QUOTES, 'UTF-8');
    $birthDate = date('d.m.Y', strtotime($teacher['birth_date']));
    $position = htmlspecialchars($teacher['position'], ENT_QUOTES, 'UTF-8');
    $department = htmlspecialchars($teacher['department'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($teacher['email'], ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($teacher['phone'], ENT_QUOTES, 'UTF-8');
    $photo = htmlspecialchars($teacher['photo'], ENT_QUOTES, 'UTF-8');
    
    // === АВТОМАТИЧЕСКОЕ РАСПРЕДЕЛЕНИЕ ФОТО ===
    $photoPath = 'uploads/teachers/' . $photo;
    if (!file_exists(__DIR__ . '/' . $photoPath) || empty($photo)) {
        $photoNum = (($id - 1) % 5) + 1;
        $photoPath = 'uploads/teachers/teacher_' . $photoNum . '.jpg';
        if (!file_exists(__DIR__ . '/' . $photoPath)) {
            $photoPath = 'placeholder.php?w=220&h=280&text=No+Photo';
        }
    }
    
    echo '<div class="modal-header">';
    echo '<h2>Информация о преподавателе</h2>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<div class="teacher-detail">';
    echo '<div class="detail-photo"><img src="' . $photoPath . '" alt="' . $fullName . '" style="max-width:280px!important; max-height:350px!important; width:auto!important; height:auto!important; object-fit:contain!important; object-position:center top!important; display:block!important; margin:0 auto!important; border-radius:12px!important;" onerror="this.src=\'placeholder.php?w=220&h=280&text=No+Photo\'"></div>';
    echo '<div class="detail-info">';
    echo '<h3>' . $fullName . '</h3>';
    echo '<p><strong>📋 Должность:</strong> ' . $position . '</p>';
    echo '<p><strong>🏛️ Кафедра:</strong> ' . $department . '</p>';
    echo '<p><strong>📧 Email:</strong> ' . $email . '</p>';
    echo '<p><strong>📱 Телефон:</strong> ' . $phone . '</p>';
    echo '<p><strong>🎂 Дата рождения:</strong> ' . $birthDate . '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="modal-footer">';
    // === ИСПРАВЛЕНИЕ: вызываем closeViewModal() вместо closeTeacherModal() ===
    echo '<button class="btn-close" onclick="closeViewModal()">Закрыть</button>';
    echo '</div>';
} else {
    echo '<p style="text-align:center;color:red;">Преподаватель не найден</p>';
}
?>