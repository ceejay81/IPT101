<?php
// config.php (assuming it contains database connection setup)
include('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Include your custom CSS file here -->
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php include('navbar.php'); ?>
    
    <!-- Sidebar -->
    <?php include('sidebar.php'); ?>
    
    <!-- Content -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Content Header</h1>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="content">
            <div class="container-fluid">
                
                <!-- PHP Code Snippets - attendance.php -->
                <?php include('attendance.php'); ?>
                
                <!-- PHP Code Snippets - events.php -->
                <?php include('events.php'); ?>
                
                <!-- PHP Code Snippets - scan.php -->
                <?php include('scan.php'); ?>
                
                <!-- PHP Code Snippets - users.php -->
                <?php include('users.php'); ?>
                
            </div>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="row">
        <div class="col-md-12">
            <h3>Attendance Records</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Event</th>
                        <th>Attendance Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT users.name as user_name, events.name as event_name, attendance.attendance_time 
                            FROM attendance 
                            JOIN users ON attendance.user_id = users.id 
                            JOIN events ON attendance.event_id = events.id";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row['user_name']."</td>
                                <td>".$row['event_name']."</td>
                                <td>".$row['attendance_time']."</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- All Events -->
    <div class="row">
        <div class="col-md-8">
            <h3>All Events</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Venue</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM events";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row['name']."</td>
                                <td>".$row['date']."</td>
                                <td>".$row['time']."</td>
                                <td>".$row['venue']."</td>
                                <td>".$row['description']."</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scan QR Code -->
    <div class="row">
        <div class="col-md-8">
            <h3>Scan QR Code</h3>
            <!-- Your form and scanning logic here -->
        </div>
    </div>

    <!-- All Users -->
    <div class="row">
        <div class="col-md-12">
            <h3>All Users</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>QR Code</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM users";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row['name']."</td>
                                <td>".$row['email']."</td>
                                <td><img src='".$row['qr_code']."' alt='QR Code' width='100'></td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>
</div>

<!-- JavaScript -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
