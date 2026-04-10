<?php 
header('Content-Type: text/html; charset=utf-8');
include 'includes/header.php';
mysqli_set_charset($conn, "utf8mb4");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Преподаватели - Ангарский политехнический техникум</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<section class="page-header">
    <div class="container">
        <h1>Наши преподаватели</h1>
        <p>Высококвалифицированные специалисты с многолетним опытом работы</p>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="table-wrapper">
            <table class="stable-table">
                <thead>
                    <tr>
                        <th width="180">Фото</th>
                        <th>ФИО</th>
                        <th>Должность</th>
                        <th>Кафедра</th>
                        <th>Email</th>
                        <th width="150">Телефон</th>
                        <th width="120">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM teachers ORDER BY last_name, first_name");
                    
                    if ($result && $result->num_rows > 0) {
                        while($teacher = $result->fetch_assoc()) {
                            $fullName = htmlspecialchars($teacher['last_name'] . ' ' . $teacher['first_name'] . ' ' . $teacher['middle_name'], ENT_QUOTES, 'UTF-8');
                            $position = htmlspecialchars($teacher['position'], ENT_QUOTES, 'UTF-8');
                            $department = htmlspecialchars($teacher['department'], ENT_QUOTES, 'UTF-8');
                            $email = htmlspecialchars($teacher['email'], ENT_QUOTES, 'UTF-8');
                            $phone = htmlspecialchars($teacher['phone'], ENT_QUOTES, 'UTF-8');
                            $photo = htmlspecialchars($teacher['photo'], ENT_QUOTES, 'UTF-8');
                            $teacherId = $teacher['id'];
                            
                            $photoPath = 'uploads/teachers/' . $photo;
                            if (!file_exists(__DIR__ . '/' . $photoPath) || empty($photo)) {
                                $photoNum = (($teacherId - 1) % 5) + 1;
                                $photoPath = 'uploads/teachers/teacher_' . $photoNum . '.jpg';
                                if (!file_exists(__DIR__ . '/' . $photoPath)) {
                                    $photoPath = 'placeholder.php?w=100&h=120&text=No+Photo';
                                }
                            }
                            
                            echo '<tr>';
                            echo '<td><img src="' . $photoPath . '" alt="Фото" class="table-photo" style="max-width:100px!important; max-height:100px!important; width:auto!important; height:auto!important; object-fit:contain!important; display:block!important; margin:0 auto!important;" onerror="this.src=\'placeholder.php?w=100&h=120&text=No+Photo\'"></td>';
                            echo '<td class="name-cell">' . $fullName . '</td>';
                            echo '<td>' . $position . '</td>';
                            echo '<td>' . $department . '</td>';
                            echo '<td>' . $email . '</td>';
                            echo '<td>' . $phone . '</td>';
                            echo '<td class="actions-cell">';
                            echo '<button class="btn-view" onclick="openTeacherModal(' . $teacherId . ')">';
                            echo '<i class="fas fa-eye"></i> Просмотр';
                            echo '</button>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7" style="text-align:center;padding:40px;color:#666;">Нет данных для отображения</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Модальное окно -->
<div id="teacherModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeTeacherModal()">&times;</span>
        <div id="modalBody">
            <p style="text-align:center;padding:40px;">Загрузка...</p>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <p>&copy; 2026 Ангарский политехнический техникум. Все права защищены.</p>
        <p>📞 Телефон: +7 (3955) 12-34-56 | 📧 Email: info@apt.ru</p>
    </div>
</footer>

<script>
function openTeacherModal(id) {
    document.getElementById('teacherModal').style.display = 'block';
    document.getElementById('modalBody').innerHTML = '<p style="text-align:center;padding:40px;">Загрузка...</p>';
    
    fetch('get_teacher.php?id=' + id)
        .then(response => response.text())
        .then(data => {
            document.getElementById('modalBody').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('modalBody').innerHTML = '<p style="color:red;text-align:center;">Ошибка загрузки данных</p>';
        });
}

function closeTeacherModal() {
    document.getElementById('teacherModal').style.display = 'none';
}

window.onclick = function(event) {
    var modal = document.getElementById('teacherModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
</body>
</html>