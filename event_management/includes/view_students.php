<?php
session_start();
include('../config/database.php'); // Adjust the path as necessary

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

$teacher_id = $_SESSION['user_id'];

// Fetch enrolled students
$sql = "SELECT student_id, fullname, course FROM students WHERE teacher_id = '$teacher_id'";
$enrolled_students = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">View Students</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Full Name</th>
                                            <th>Course</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($enrolled_students && mysqli_num_rows($enrolled_students) > 0) {
                                            while ($student = mysqli_fetch_assoc($enrolled_students)) {
                                                echo "<tr>";
                                                echo "<td>" . $student['student_id'] . "</td>";
                                                echo "<td>" . $student['fullname'] . "</td>";
                                                echo "<td>" . $student['course'] . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3'>No students enrolled yet.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
