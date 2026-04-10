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
    <title>Студенты - Ангарский политехнический техникум</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<section class="page-header">
    <div class="container">
        <h1>Наши студенты</h1>
        <p>Талантливые и целеустремленные обучающиеся Ангарского политехнического техникума</p>
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
                        <th width="100">Группа</th>
                        <th>Email</th>
                        <th width="150">Телефон</th>
                        <th width="120">Дата рождения</th>
                        <th width="120">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM students ORDER BY last_name, first_name");
                    
                    if ($result && $result->num_rows > 0) {
                        while($student = $result->fetch_assoc()) {
                            $fullName = htmlspecialchars($student['last_name'] . ' ' . $student['first_name'] . ' ' . $student['middle_name'], ENT_QUOTES, 'UTF-8');
                            $birthDate = date('d.m.Y', strtotime($student['birth_date']));
                            $email = htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8');
                            $phone = htmlspecialchars($student['phone'], ENT_QUOTES, 'UTF-8');
                            $groupName = htmlspecialchars($student['group_name'], ENT_QUOTES, 'UTF-8');
                            $photo = htmlspecialchars($student['photo'], ENT_QUOTES, 'UTF-8');
                            $studentId = $student['id'];
                            
                            $photoPath = 'uploads/students/' . $photo;
                            if (!file_exists(__DIR__ . '/' . $photoPath) || empty($photo)) {
                                $photoNum = (($studentId - 1) % 5) + 1;
                                $photoPath = 'uploads/students/student_' . $photoNum . '.jpg';
                                if (!file_exists(__DIR__ . '/' . $photoPath)) {
                                    $photoPath = 'placeholder.php?w=100&h=120&text=No+Photo';
                                }
                            }
                            
                            echo '<tr>';
                            echo '<td><img src="' . $photoPath . '" alt="Фото" class="table-photo" style="max-width:100px!important; max-height:100px!important; width:auto!important; height:auto!important; object-fit:contain!important; display:block!important; margin:0 auto!important;" onerror="this.src=\'placeholder.php?w=100&h=120&text=No+Photo\'"></td>';
                            echo '<td class="name-cell">' . $fullName . '</td>';
                            echo '<td>' . $groupName . '</td>';
                            echo '<td>' . $email . '</td>';
                            echo '<td>' . $phone . '</td>';
                            echo '<td>' . $birthDate . '</td>';
                            echo '<td class="actions-cell">';
                            echo '<button class="btn-view" onclick="openStudentModal(' . $studentId . ')">';
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
<div id="studentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeStudentModal()">&times;</span>
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
function openStudentModal(id) {
    document.getElementById('studentModal').style.display = 'block';
    document.getElementById('modalBody').innerHTML = '<p style="text-align:center;padding:40px;">Загрузка...</p>';
    
    fetch('get_student.php?id=' + id)
        .then(response => response.text())
        .then(data => {
            document.getElementById('modalBody').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('modalBody').innerHTML = '<p style="color:red;text-align:center;">Ошибка загрузки данных</p>';
        });
}

function closeStudentModal() {
    document.getElementById('studentModal').style.display = 'none';
}

window.onclick = function(event) {
    var modal = document.getElementById('studentModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
</body>
</html>