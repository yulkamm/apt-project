<?php
header('Content-Type: text/html; charset=utf-8');
include 'config.php';
mysqli_set_charset($conn, "utf8mb4");

if (!isset($_GET['id'])) {
    echo '<p>Ошибка: не указан ID</p>';
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM students WHERE id = $id");

if ($student = $result->fetch_assoc()) {
    $fullName = htmlspecialchars($student['last_name'] . ' ' . $student['first_name'] . ' ' . $student['middle_name'], ENT_QUOTES, 'UTF-8');
    $birthDate = date('d.m.Y', strtotime($student['birth_date']));
    $email = htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($student['phone'], ENT_QUOTES, 'UTF-8');
    $groupName = htmlspecialchars($student['group_name'], ENT_QUOTES, 'UTF-8');
    $photo = htmlspecialchars($student['photo'], ENT_QUOTES, 'UTF-8');
    
    // === АВТОМАТИЧЕСКОЕ РАСПРЕДЕЛЕНИЕ ФОТО ===
    $photoPath = 'uploads/students/' . $photo;
    if (!file_exists(__DIR__ . '/' . $photoPath) || empty($photo)) {
        $photoNum = (($id - 1) % 5) + 1;
        $photoPath = 'uploads/students/student_' . $photoNum . '.jpg';
        if (!file_exists(__DIR__ . '/' . $photoPath)) {
            $photoPath = 'placeholder.php?w=220&h=280&text=No+Photo';
        }
    }
    
    echo '<div class="modal-header">';
    echo '<h2>Информация о студенте</h2>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<div class="student-detail">';
    echo '<div class="detail-photo"><img src="' . $photoPath . '" alt="' . $fullName . '" style="max-width:280px!important; max-height:350px!important; width:auto!important; height:auto!important; object-fit:contain!important; object-position:center top!important; display:block!important; margin:0 auto!important; border-radius:12px!important;" onerror="this.src=\'placeholder.php?w=220&h=280&text=No+Photo\'"></div>';
    echo '<div class="detail-info">';
    echo '<h3>' . $fullName . '</h3>';
    echo '<p><strong>🎓 Группа:</strong> ' . $groupName . '</p>';
    echo '<p><strong>📧 Email:</strong> ' . $email . '</p>';
    echo '<p><strong>📱 Телефон:</strong> ' . $phone . '</p>';
    echo '<p><strong>🎂 Дата рождения:</strong> ' . $birthDate . '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="modal-footer">';
    // === ИСПРАВЛЕНИЕ: вызываем closeViewModal() вместо closeStudentModal() ===
    echo '<button class="btn-close" onclick="closeViewModal()">Закрыть</button>';
    echo '</div>';
} else {
    echo '<p style="text-align:center;color:red;">Студент не найден</p>';
}
?>