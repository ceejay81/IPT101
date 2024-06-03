<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    

</head>
<body>
    <div class="container">
        <h2>Mark Attendance</h2>
        <div class="row">
            <div class="col-md-6">
                <a href="scan_qr_code.php" class="btn btn-primary btn-lg btn-block">Scan QR Code</a>
            </div>
            <div class="col-md-6">
                <a href="manual_attendance.php" class="btn btn-secondary btn-lg btn-block">Enter Student ID</a>
            </div>
        </div>
    </div>
</body>
</html>
