<?php
include('config/database.php');
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle attendance recording when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['qr_code'])) {
    // Sanitize input to prevent SQL injection
    $qr_code = mysqli_real_escape_string($conn, $_POST['qr_code']);

    // Extract user_id from the QR code (assuming the QR code contains user_id)
    preg_match('/User ID: (\d+)/', $qr_code, $matches);
    $user_id = isset($matches[1]) ? intval($matches[1]) : null;

    if ($user_id !== null) {
        // Record attendance
        $event_id = intval($_POST['event_id']);
        $sql = "INSERT INTO attendance (event_id, user_id) VALUES ('$event_id', '$user_id')";
        if (mysqli_query($conn, $sql)) {
            $success_message = "Attendance recorded successfully.";
        } else {
            $error_message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        $error_message = "Invalid QR code format.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Scan QR Code</title>
    <!-- Include necessary CSS files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <!-- Include necessary JS files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
 
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Scan QR Code</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <?php if (isset($success_message)) : ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $success_message; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($error_message)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="form-group">
                                <label for="qr_code">QR Code</label>
                                <input type="text" class="form-control" id="qr_code" name="qr_code" placeholder="Enter QR Code" required>
                            </div>
                            <div class="form-group">
                                <label for="event_id">Event ID</label>
                                <input type="number" class="form-control" id="event_id" name="event_id" placeholder="Enter Event ID" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Record Attendance</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <?php include('includes/sidebar.php'); ?>
    <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->
</body>
</html>
