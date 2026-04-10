-- Установка кодировки
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Создание базы данных с правильной кодировкой
CREATE DATABASE IF NOT EXISTS apt_database 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE apt_database;

-- Таблица студентов
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    last_name VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    middle_name VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    birth_date DATE,
    group_name VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    email VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    phone VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    photo VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица преподавателей
CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    last_name VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    middle_name VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    birth_date DATE,
    position VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    department VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    email VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    phone VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    photo VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Данные студентов (10 записей)
INSERT INTO students (first_name, last_name, middle_name, birth_date, group_name, email, phone, photo) VALUES
('Иван', 'Петров', 'Сергеевич', '2005-03-15', 'ПИ-21', 'ivan.petrov@apt.ru', '+7 (999) 111-22-33', 'student_1.jpg'),
('Мария', 'Сидорова', 'Александровна', '2004-07-22', 'ПИ-21', 'maria.sidorova@apt.ru', '+7 (999) 222-33-44', 'student_2.jpg'),
('Алексей', 'Козлов', 'Дмитриевич', '2005-01-10', 'ПИ-22', 'alexey.kozlov@apt.ru', '+7 (999) 333-44-55', 'student_3.jpg'),
('Елена', 'Новикова', 'Ивановна', '2004-11-05', 'ПИ-22', 'elena.novikova@apt.ru', '+7 (999) 444-55-66', 'student_4.jpg'),
('Дмитрий', 'Волков', 'Андреевич', '2005-05-18', 'ПИ-23', 'dmitry.volkov@apt.ru', '+7 (999) 555-66-77', 'student_5.jpg'),
('Анна', 'Кузнецова', 'Петровна', '2004-09-30', 'ПИ-23', 'anna.kuznetsova@apt.ru', '+7 (999) 666-77-88', 'student_6.jpg'),
('Сергей', 'Попов', 'Владимирович', '2005-02-14', 'ПИ-24', 'sergey.popov@apt.ru', '+7 (999) 777-88-99', 'student_7.jpg'),
('Ольга', 'Соколова', 'Дмитриевна', '2004-12-25', 'ПИ-24', 'olga.sokolova@apt.ru', '+7 (999) 888-99-00', 'student_8.jpg'),
('Михаил', 'Лебедев', 'Александрович', '2005-06-08', 'ПИ-25', 'mikhail.lebedev@apt.ru', '+7 (999) 999-00-11', 'student_9.jpg'),
('Татьяна', 'Васильева', 'Сергеевна', '2004-04-17', 'ПИ-25', 'tatyana.vasileva@apt.ru', '+7 (999) 000-11-22', 'student_10.jpg');

-- Данные преподавателей (10 записей)
INSERT INTO teachers (first_name, last_name, middle_name, birth_date, position, department, email, phone, photo) VALUES
('Анна', 'Смирнова', 'Владимировна', '1980-04-12', 'Старший преподаватель', 'Кафедра программирования', 'anna.smirnova@apt.ru', '+7 (999) 111-00-01', 'teacher_1.jpg'),
('Сергей', 'Кузнецов', 'Петрович', '1975-09-25', 'Доцент', 'Кафедра информационных систем', 'sergey.kuznetsov@apt.ru', '+7 (999) 222-00-02', 'teacher_2.jpg'),
('Ольга', 'Попова', 'Сергеевна', '1982-12-03', 'Преподаватель', 'Кафедра программирования', 'olga.popova@apt.ru', '+7 (999) 333-00-03', 'teacher_3.jpg'),
('Михаил', 'Соколов', 'Александрович', '1978-06-17', 'Заведующий кафедрой', 'Кафедра информационных технологий', 'mikhail.sokolov@apt.ru', '+7 (999) 444-00-04', 'teacher_4.jpg'),
('Татьяна', 'Лебедева', 'Дмитриевна', '1985-02-28', 'Преподаватель', 'Кафедра математики', 'tatyana.lebedeva@apt.ru', '+7 (999) 555-00-05', 'teacher_5.jpg'),
('Александр', 'Новиков', 'Иванович', '1972-11-11', 'Профессор', 'Кафедра экономики', 'alexander.novikov@apt.ru', '+7 (999) 666-00-06', 'teacher_6.jpg'),
('Елена', 'Васильева', 'Андреевна', '1983-07-19', 'Преподаватель', 'Кафедра иностранных языков', 'elena.vasileva@apt.ru', '+7 (999) 777-00-07', 'teacher_7.jpg'),
('Дмитрий', 'Волков', 'Сергеевич', '1979-03-05', 'Доцент', 'Кафедра физики', 'dmitry.volkov@apt.ru', '+7 (999) 888-00-08', 'teacher_8.jpg'),
('Наталья', 'Морозова', 'Петровна', '1981-08-23', 'Преподаватель', 'Кафедра химии', 'natalya.morozova@apt.ru', '+7 (999) 999-00-09', 'teacher_9.jpg'),
('Андрей', 'Павлов', 'Дмитриевич', '1976-01-15', 'Старший преподаватель', 'Кафедра механики', 'andrey.pavlov@apt.ru', '+7 (999) 000-00-10', 'teacher_10.jpg');
-- ========================================
-- ТАБЛИЦА ПОЛЬЗОВАТЕЛЕЙ (для авторизации)
-- ========================================

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    full_name VARCHAR(150),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Создание суперпользователей
-- Пароль для обоих: admin123 / yulia123
INSERT INTO users (username, email, password, role, full_name) VALUES
('admin', 'admin@apt.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Администратор'),
('yulia', 'yulia@apt.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Юлия');