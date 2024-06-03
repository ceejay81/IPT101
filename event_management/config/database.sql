CREATE DATABASE project_event;

USE project_event;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('student', 'teacher') NOT NULL,
    student_id VARCHAR(50),
    teacher_id INT,
    fullname VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
