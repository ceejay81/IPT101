<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include('../config/database.php');

// Retrieve student information
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);

// Fetch attendance for the student (example query, adjust as needed)
$sql = "SELECT * FROM attendance WHERE student_id = '$user_id'";
$attendance = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- Add your custom stylesheets if needed -->
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
    <?php include('sidebar.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Priority Events Section -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Priority Events</h3>
                            </div>
                            <div class="card-body">
                                <!-- Display priority events here -->
                                <?php while ($event = mysqli_fetch_assoc($priority_events)): ?>
                                    <!-- Display event details -->
                                    <div><?php echo $event['name']; ?></div>
                                    <!-- Add more event details as needed -->
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Section -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Attendance</h3>
                            </div>
                            <div class="card-body">
                                <!-- Display attendance details here -->
                                <!-- Example: Total classes attended, percentage, etc. -->
                                <p>Attendance details will be displayed here</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Scan QR Code</h3>
                            </div>
                            <div class="card-body">
                                <!-- Add QR code scanning functionality here -->
                                <!-- This section can be implemented using JavaScript libraries -->
                                <p>QR code scanning feature will be added here</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add any additional sections or features as needed -->

            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>
</div>
<!-- ./wrapper -->

<!-- Add your custom scripts if needed -->

</body>
</html>
