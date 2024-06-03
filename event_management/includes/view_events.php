<?php
session_start();
include('../config/database.php'); // Adjust the path as necessary

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

$teacher_id = $_SESSION['user_id'];

// Fetch events for the teacher
$sql = "SELECT * FROM events WHERE teacher_id = '$teacher_id'";
$events_result = mysqli_query($conn, $sql);

// Check if any events are returned
if (!$events_result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Events</title>
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
                            <a href="view_events.php" class="nav-link active">
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
                            <h1 class="m-0">View Events</h1>
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
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Venue</th>
                                                <th>Description</th>
                                                <th>Expiration Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch and display events
                                            if (mysqli_num_rows($events_result) > 0) {
                                                while ($event = mysqli_fetch_assoc($events_result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $event['id'] . "</td>";
                                                    echo "<td>" . $event['name'] . "</td>";
                                                    echo "<td>" . $event['date'] . "</td>";
                                                    echo "<td>" . $event['time'] . "</td>";
                                                    echo "<td>" . $event['venue'] . "</td>";
                                                    echo "<td>" . $event['description'] . "</td>";
                                                    echo "<td>" . $event['expiration_date'] . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>No events found.</td></tr>";
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
