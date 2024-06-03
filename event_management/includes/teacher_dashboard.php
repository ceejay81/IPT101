<?php
session_start();
include('../config/database.php'); // Adjust the path as necessary

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

$teacher_id = $_SESSION['user_id'];

// Fetch teacher information
$sql = "SELECT fullname, email FROM users WHERE id = '$teacher_id' AND role = 'teacher'";
$result = mysqli_query($conn, $sql);
$teacher = mysqli_fetch_assoc($result);

// Fetch students associated with the teacher
$sql = "SELECT student_id, fullname FROM users WHERE teacher_id = '$teacher_id' AND role = 'student'";
$students = mysqli_query($conn, $sql);

// Fetch events attended by students of the teacher
$sql = "SELECT DISTINCT events.* 
        FROM events 
        JOIN attendance ON events.id = attendance.event_id 
        JOIN users ON attendance.user_id = users.id 
        WHERE users.teacher_id = '$teacher_id'";
$events = mysqli_query($conn, $sql);

if (!$events) {
    die("Error: " . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher Info Box -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Teacher Information</h3>
                            </div>
                            <div class="card-body">
                                <strong><i class="fas fa-user"></i> Full Name</strong>
                                <p class="text-muted"><?php echo $teacher['fullname']; ?></p>
                                <hr>
                                <strong><i class="fas fa-envelope"></i> Email</strong>
                                <p class="text-muted"><?php echo $teacher['email']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Students List Box -->
                       
                    </div>
                </div>

                                <!-- Events List Box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Events</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Location</th>
                                    <th>Description</th>
                                    <th>Expiration Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch events
                                $sql = "SELECT * FROM events WHERE teacher_id = '$teacher_id'";
                                $events_result = mysqli_query($conn, $sql);

                                // Check if any events are returned
                                if ($events_result) {
                                    // Fetch and display events
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
                                    echo "<tr><td colspan='6'>No events found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </section>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
