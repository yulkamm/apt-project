<?php
include 'auth.php';
requireAdmin();
mysqli_set_charset($conn, "utf8mb4");

// Удаление
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM teachers WHERE id = $id");
    header('Location: admin_teachers.php?deleted=1');
    exit;
}

// Добавление/Редактирование
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
        $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
        $middleName = mysqli_real_escape_string($conn, $_POST['middle_name']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $photo = mysqli_real_escape_string($conn, $_POST['photo']);
        
        $sql = "INSERT INTO teachers (first_name, last_name, middle_name, position, department, email, phone, photo) 
                VALUES ('$firstName', '$lastName', '$middleName', '$position', '$department', '$email', '$phone', '$photo')";
        
        if ($conn->query($sql)) {
            $message = 'Преподаватель добавлен!';
        }
    } elseif ($action === 'edit') {
        $id = intval($_POST['id']);
        $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
        $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
        $middleName = mysqli_real_escape_string($conn, $_POST['middle_name']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $photo = mysqli_real_escape_string($conn, $_POST['photo']);
        
        $sql = "UPDATE teachers SET first_name='$firstName', last_name='$lastName', middle_name='$middleName',
                position='$position', department='$department', email='$email', phone='$phone', photo='$photo'
                WHERE id=$id";
        
        if ($conn->query($sql)) {
            $message = 'Преподаватель обновлен!';
        }
    }
}

// === Сортировка по ID ===
$teachers = $conn->query("SELECT * FROM teachers ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление преподавателями - АПТ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1>👨‍🏫 Управление преподавателями</h1>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <?php if ($message): ?>
                <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_GET['deleted'])): ?>
                <div class="success-message">Преподаватель удалён!</div>
            <?php endif; ?>

            <button class="btn-admin" onclick="showAddForm()">+ Добавить преподавателя</button>
            
            <div class="table-wrapper">
                <table class="stable-table">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th width="120">Фото</th>
                            <th>ФИО</th>
                            <th>Должность</th>
                            <th>Кафедра</th>
                            <th>Email</th>
                            <th width="150">Телефон</th>
                            <th width="120">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($teacher = $teachers->fetch_assoc()): 
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
                        ?>
                            <tr>
                                <td><?php echo $teacher['id']; ?></td>
                                <td><img src="<?php echo $photoPath; ?>" alt="Фото" class="table-photo" style="max-width:100px!important; max-height:100px!important; width:auto!important; height:auto!important; object-fit:contain!important; display:block!important; margin:0 auto!important;" onerror="this.src='placeholder.php?w=100&h=120&text=No+Photo'"></td>
                                <td class="name-cell"><?php echo htmlspecialchars($teacher['last_name'] . ' ' . $teacher['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($teacher['position']); ?></td>
                                <td><?php echo htmlspecialchars($teacher['department']); ?></td>
                                <td><?php echo htmlspecialchars($teacher['email']); ?></td>
                                <td><?php echo htmlspecialchars($teacher['phone']); ?></td>
                                <td class="actions-cell">
                                    <button class="btn-view" onclick="viewTeacher(<?php echo $teacher['id']; ?>)" style="margin-right:5px;">👁️</button>
                                    <button class="btn-edit" onclick="editTeacher(<?php echo htmlspecialchars(json_encode($teacher, JSON_HEX_APOS | JSON_HEX_QUOT)); ?>)">✏️</button>
                                    <button class="btn-delete" onclick="if(confirm('Удалить?')) location.href='?delete=<?php echo $teacher['id']; ?>'">🗑️</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Модальное окно для просмотра -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeViewModal()">&times;</span>
            <div id="viewModalBody">
                <p style="text-align:center;padding:40px;">Загрузка...</p>
            </div>
        </div>
    </div>

    <!-- Модальное окно для добавления/редактирования -->
    <div id="teacherModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-header">
                <h2 id="modalTitle">Добавить преподавателя</h2>
            </div>
            <div class="modal-body">
                <form method="POST" id="teacherForm">
                    <input type="hidden" name="action" id="formAction" value="add">
                    <input type="hidden" name="id" id="teacherId">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Фамилия</label>
                            <input type="text" name="last_name" id="lastName" required>
                        </div>
                        <div class="form-group">
                            <label>Имя</label>
                            <input type="text" name="first_name" id="firstName" required>
                        </div>
                        <div class="form-group">
                            <label>Отчество</label>
                            <input type="text" name="middle_name" id="middleName">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Должность</label>
                            <input type="text" name="position" id="position" required>
                        </div>
                        <div class="form-group">
                            <label>Кафедра</label>
                            <input type="text" name="department" id="department" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label>Телефон</label>
                            <input type="text" name="phone" id="phone" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Фото (имя файла)</label>
                        <input type="text" name="photo" id="photo" placeholder="teacher_1.jpg">
                    </div>
                    
                    <button type="submit" class="btn-submit">Сохранить</button>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2026 Ангарский политехнический техникум</p>
        </div>
    </footer>

    <script>
    // Просмотр преподавателя
    function viewTeacher(id) {
        document.getElementById('viewModal').style.display = 'block';
        document.getElementById('viewModalBody').innerHTML = '<p style="text-align:center;padding:40px;">Загрузка...</p>';
        
        fetch('get_teacher.php?id=' + id)
            .then(response => response.text())
            .then(data => {
                document.getElementById('viewModalBody').innerHTML = data;
            })
            .catch(error => {
                document.getElementById('viewModalBody').innerHTML = '<p style="color:red;text-align:center;">Ошибка загрузки</p>';
            });
    }
    
    function closeViewModal() {
        document.getElementById('viewModal').style.display = 'none';
    }

    // Добавление/редактирование
    function showAddForm() {
        document.getElementById('modalTitle').textContent = 'Добавить преподавателя';
        document.getElementById('formAction').value = 'add';
        document.getElementById('teacherForm').reset();
        document.getElementById('teacherModal').style.display = 'block';
    }

    function editTeacher(teacher) {
        document.getElementById('modalTitle').textContent = 'Редактировать преподавателя';
        document.getElementById('formAction').value = 'edit';
        document.getElementById('teacherId').value = teacher.id;
        document.getElementById('lastName').value = teacher.last_name;
        document.getElementById('firstName').value = teacher.first_name;
        document.getElementById('middleName').value = teacher.middle_name || '';
        document.getElementById('position').value = teacher.position;
        document.getElementById('department').value = teacher.department;
        document.getElementById('email').value = teacher.email;
        document.getElementById('phone').value = teacher.phone;
        document.getElementById('photo').value = teacher.photo || '';
        document.getElementById('teacherModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('teacherModal').style.display = 'none';
    }

    // Закрытие модальных окон по клику вне
    window.onclick = function(event) {
        if (event.target == document.getElementById('viewModal')) {
            closeViewModal();
        }
        if (event.target == document.getElementById('teacherModal')) {
            closeModal();
        }
    }
    </script>
</body>
</html>