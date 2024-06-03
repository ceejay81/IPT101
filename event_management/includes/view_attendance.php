<?php
session_start();
include('../config/database.php'); // Include the database connection file

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

$teacher_id = $_SESSION['user_id'];

// Fetch teacher information
$sql = "SELECT fullname, email FROM users WHERE id = '$teacher_id' AND role = 'teacher'";
$result = mysqli_query($conn, $sql);
$teacher = mysqli_fetch_assoc($result);

// Fetch events
$sql = "SELECT * FROM events WHERE teacher_id = '$teacher_id'";
$events = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
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
                            <a href="view_attendance.php" class="nav-link active">
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
                        <div class="col-md-6">
                            <h1 class="m-6">View Attendance</h1>
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
                                    <h5 class="card-title">Attendance Records</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Event</th>
                                                <th>Student Name</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($event = mysqli_fetch_assoc($events)) {
                                                $event_id = $event['id'];
                                                $event_name = $event['name'];
                                                $attendance_query = "
                                                    SELECT a.status, s.fullname 
                                                    FROM attendance a 
                                                    INNER JOIN students s ON a.student_id = s.id 
                                                    WHERE a.event_id = '$event_id'
                                                ";
                                                $attendance_result = mysqli_query($conn, $attendance_query);
                                                while ($attendance_row = mysqli_fetch_assoc($attendance_result)) {
                                                    $student_name = $attendance_row['fullname'];
                                                    $status = $attendance_row['status'];
                                                    echo "<tr>";
                                                    echo "<td>$event_name</td>";
                                                    echo "<td>$student_name</td>";
                                                    echo "<td>$status</td>";
                                                    echo "</tr>";
                                                }
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
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include '../includes/footer.php'; ?>
    </div>
    <!-- ./wrapper -->
    <!-- AdminLTE JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>
</html>
