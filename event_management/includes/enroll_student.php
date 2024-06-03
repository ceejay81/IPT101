<?php
session_start();
include('../config/database.php'); // Adjust the path as necessary

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

$errors = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check for empty fields
    if (empty($student_id)) {
        $errors['student_id'] = "Student ID is required";
    }
    if (empty($fullname)) {
        $errors['fullname'] = "Full name is required";
    }
    if (empty($course)) {
        $errors['course'] = "Course is required";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required";
    }

    // Check if the student ID already exists
    $check_query = "SELECT COUNT(*) as count FROM students WHERE student_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "s", $student_id);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_bind_result($check_stmt, $count);
    mysqli_stmt_fetch($check_stmt);
    mysqli_stmt_close($check_stmt);

    if ($count > 0) {
        $errors['student_id'] = "Student ID already exists";
    }

    // If no errors, insert the student record into the database
    if (empty($errors)) {
        $teacher_id = $_SESSION['user_id'];
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO students (student_id, fullname, course, teacher_id, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $student_id, $fullname, $course, $teacher_id, $hashed_password);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: teacher_dashboard.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Student</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">Teacher Dashboard</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="teacher_dashboard.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="add_event.php" class="nav-link">
                            <i class="nav-icon fas fa-calendar-plus"></i>
                            <p>Add Event</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="view_events.php" class="nav-link">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>View Events</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_attendance.php" class="nav-link">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>Manage Attendance</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="enroll_student.php" class="nav-link">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>Enroll Student</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="view_students.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>View Students</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="view_attendance.php" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>View Attendance</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-6">Enroll Student</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Enroll Student</h5>
                                    <!-- Enroll Student Form -->
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="student_id">Student ID:</label>
                                            <input type="text" class="form-control" id="student_id" name="student_id" required>
                                            <?php if (!empty($errors['student_id'])) : ?>
                                                <p class="text-danger"><?php echo $errors['student_id']; ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="fullname">Full Name:</label>
                                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                                            <?php if (!empty($errors['fullname'])) : ?>
                                                <p class="text-danger"><?php echo $errors['fullname']; ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="course">Course:</label>
                                            <input type="text" class="form-control" id="course" name="course" required>
                                            <?php if (!empty($errors['course'])) : ?>
                                                <p class="text-danger"><?php echo $errors['course']; ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password:</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                            <?php if (!empty($errors['password'])) : ?>
                                                <p class="text-danger"><?php echo $errors['password']; ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Enroll</button>
                                    </form>

                                    <!-- Display form errors -->
                                    <?php if (!empty($errors)) : ?>
                                        <div class="alert alert-danger mt-3">
                                            <ul>
                                                <?php foreach ($errors as $error) : ?>
                                                    <li><?php echo $error; ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include '../includes/footer.php'; ?>
    </div>
        <!-- AdminLTE JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

    </body>
</html>

