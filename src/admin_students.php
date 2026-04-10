<?php
include 'auth.php';
requireAdmin();
mysqli_set_charset($conn, "utf8mb4");

// Удаление
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM students WHERE id = $id");
    header('Location: admin_students.php?deleted=1');
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
        $birthDate = $_POST['birth_date'];
        $groupName = mysqli_real_escape_string($conn, $_POST['group_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $photo = mysqli_real_escape_string($conn, $_POST['photo']);
        
        $sql = "INSERT INTO students (first_name, last_name, middle_name, birth_date, group_name, email, phone, photo) 
                VALUES ('$firstName', '$lastName', '$middleName', '$birthDate', '$groupName', '$email', '$phone', '$photo')";
        
        if ($conn->query($sql)) {
            $message = 'Студент добавлен!';
        }
    } elseif ($action === 'edit') {
        $id = intval($_POST['id']);
        $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
        $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
        $middleName = mysqli_real_escape_string($conn, $_POST['middle_name']);
        $birthDate = $_POST['birth_date'];
        $groupName = mysqli_real_escape_string($conn, $_POST['group_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $photo = mysqli_real_escape_string($conn, $_POST['photo']);
        
        $sql = "UPDATE students SET first_name='$firstName', last_name='$lastName', middle_name='$middleName',
                birth_date='$birthDate', group_name='$groupName', email='$email', phone='$phone', photo='$photo'
                WHERE id=$id";
        
        if ($conn->query($sql)) {
            $message = 'Студент обновлен!';
        }
    }
}

// === ИСПРАВЛЕНИЕ: сортировка по ID ===
$students = $conn->query("SELECT * FROM students ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление студентами - АПТ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1>👤 Управление студентами</h1>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <?php if ($message): ?>
                <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_GET['deleted'])): ?>
                <div class="success-message">Студент удалён!</div>
            <?php endif; ?>

            <button class="btn-admin" onclick="showAddForm()">+ Добавить студента</button>
            
            <div class="table-wrapper">
                <table class="stable-table">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th width="120">Фото</th>
                            <th>ФИО</th>
                            <th>Группа</th>
                            <th>Email</th>
                            <th width="150">Телефон</th>
                            <th width="120">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($student = $students->fetch_assoc()): 
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
                        ?>
                            <tr>
                                <td><?php echo $student['id']; ?></td>
                                <td><img src="<?php echo $photoPath; ?>" alt="Фото" class="table-photo" style="max-width:100px!important; max-height:100px!important; width:auto!important; height:auto!important; object-fit:contain!important; display:block!important; margin:0 auto!important;" onerror="this.src='placeholder.php?w=100&h=120&text=No+Photo'"></td>
                                <td class="name-cell"><?php echo htmlspecialchars($student['last_name'] . ' ' . $student['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['group_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td><?php echo htmlspecialchars($student['phone']); ?></td>
                                <td class="actions-cell">
                                    <button class="btn-view" onclick="viewStudent(<?php echo $student['id']; ?>)" style="margin-right:5px;">👁️</button>
                                    <button class="btn-edit" onclick="editStudent(<?php echo htmlspecialchars(json_encode($student, JSON_HEX_APOS | JSON_HEX_QUOT)); ?>)">✏️</button>
                                    <button class="btn-delete" onclick="if(confirm('Удалить?')) location.href='?delete=<?php echo $student['id']; ?>'">🗑️</button>
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
    <div id="studentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-header">
                <h2 id="modalTitle">Добавить студента</h2>
            </div>
            <div class="modal-body">
                <form method="POST" id="studentForm">
                    <input type="hidden" name="action" id="formAction" value="add">
                    <input type="hidden" name="id" id="studentId">
                    
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
                            <label>Дата рождения</label>
                            <input type="date" name="birth_date" id="birthDate" required>
                        </div>
                        <div class="form-group">
                            <label>Группа</label>
                            <input type="text" name="group_name" id="groupName" required>
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
                        <input type="text" name="photo" id="photo" placeholder="student_1.jpg">
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
    // Просмотр студента
    function viewStudent(id) {
        document.getElementById('viewModal').style.display = 'block';
        document.getElementById('viewModalBody').innerHTML = '<p style="text-align:center;padding:40px;">Загрузка...</p>';
        
        fetch('get_student.php?id=' + id)
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
        document.getElementById('modalTitle').textContent = 'Добавить студента';
        document.getElementById('formAction').value = 'add';
        document.getElementById('studentForm').reset();
        document.getElementById('studentModal').style.display = 'block';
    }

    function editStudent(student) {
        document.getElementById('modalTitle').textContent = 'Редактировать студента';
        document.getElementById('formAction').value = 'edit';
        document.getElementById('studentId').value = student.id;
        document.getElementById('lastName').value = student.last_name;
        document.getElementById('firstName').value = student.first_name;
        document.getElementById('middleName').value = student.middle_name || '';
        document.getElementById('birthDate').value = student.birth_date;
        document.getElementById('groupName').value = student.group_name;
        document.getElementById('email').value = student.email;
        document.getElementById('phone').value = student.phone;
        document.getElementById('photo').value = student.photo || '';
        document.getElementById('studentModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('studentModal').style.display = 'none';
    }

    // Закрытие модальных окон по клику вне
    window.onclick = function(event) {
        if (event.target == document.getElementById('viewModal')) {
            closeViewModal();
        }
        if (event.target == document.getElementById('studentModal')) {
            closeModal();
        }
    }
    </script>
</body>
</html>