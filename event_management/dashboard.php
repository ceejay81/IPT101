<?php
session_start();
// Check for flash message
$flash_message = isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : '';
unset($_SESSION['flash_message']); // Clear flash message

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include('config/database.php');

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
// Display flash message if present
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <!-- Include sidebar -->
        <?php include('includes/sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <!-- Display flash message if present -->
                <?php if (!empty($flash_message)): ?>
                    <div class="alert alert-success"><?php echo $flash_message; ?></div>
                <?php endif; ?>
            <section class="content">
                <!-- Student Profile Section -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Student Profile</h3>
                    </div>
                    <div class="card-body">
                        <p><i class="fas fa-user"></i> <strong>Name:</strong> <?php echo $user['name']; ?></p>
                        <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?php echo $user['email']; ?></p>
                        <!-- Add more profile details here -->
                    </div>
                </div>
                <!-- End Student Profile Section -->

                <!-- Upcoming Events Section -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Upcoming Events</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display upcoming events from the database -->
                        <?php
                        $today = date('Y-m-d');
                        $sql = "SELECT * FROM events WHERE date >= '$today' ORDER BY date LIMIT 5";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<p><i class='far fa-calendar-alt'></i> <strong>{$row['name']}</strong> - {$row['date']}</p>";
                            }
                        } else {
                            echo "<p>No upcoming events found.</p>";
                        }
                        ?>
                    </div>
                </div>
                <!-- End Upcoming Events Section -->

                <!-- Attendance Status Section -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Attendance Status</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display attendance status based on the user's attendance records -->
                        <?php
                        $sql = "SELECT COUNT(*) AS total_attendance FROM attendance WHERE user_id = $user_id";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $total_attendance = $row['total_attendance'];
                        echo "<p><i class='fas fa-check-circle'></i> Total Attendance: $total_attendance</p>";
                        ?>
                    </div>
                </div>
                <!-- End Attendance Status Section -->
<!-- Generate QR Code Section -->
<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title">Generate QR Code</h3>
    </div>
    <div class="card-body">
        <!-- Display QR code generation option -->
       <!-- Generate QR Code Section -->
<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title">Generate QR Code</h3>
    </div>
    <div class="card-body">
        <!-- Display QR code generation option -->
        <p>Generate a QR code for easy access to your profile and attendance tracking.</p>
        <a href="generate_qr_code.php" class="btn btn-primary">Generate QR Code</a>
    </div>
    <!-- Display QR code in popup window -->
    <?php if (!empty($qr_code_file)): ?>
        <!-- Display link/button to view and download the generated QR code -->
        <div class="card-footer">
            <p>Your QR code has been generated. <a href="<?php echo $qr_code_file; ?>" download>Download QR Code</a></p>
        </div>
    <?php endif; ?>
</div>
<!-- End Generate QR Code Section -->

                <!-- Add more sections as needed -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- Include JavaScript files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    <script>
                        // Display the modal
                        var modal = document.getElementById("myModal");
                        modal.style.display = "block";

                        // Close the modal when the close button is clicked
                        var span = document.getElementsByClassName("close")[0];
                        span.onclick = function() {
                            modal.style.display = "none";
                        }

                        // Close the modal when the user clicks anywhere outside of the modal
                        window.onclick = function(event) {
                            if (event.target == modal) {
                                modal.style.display = "none";
                            }
                        }
                    </script>
</body>
</html>
