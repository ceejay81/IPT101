<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('config/database.php');

if (isset($_GET['content'])) {
    $qr_content = $_GET['content'];

    // Check if QR content matches any student ID in the database
    $sql = "SELECT * FROM users WHERE qr_code='$qr_content'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // QR content matches a student ID, mark attendance
        $row = $result->fetch_assoc();
        $student_id = $row['id'];
        $event_id = $_SESSION['event_id']; // Assuming you store the event ID in session
        $attendance_time = date("Y-m-d H:i:s");

        // Insert attendance record into the database
        $sql = "INSERT INTO attendance (user_id, event_id, attendance_time) VALUES ('$student_id', '$event_id', '$attendance_time')";
        if ($conn->query($sql) === TRUE) {
            $success_message = "Attendance marked successfully!";
        } else {
            $error_message = "Error marking attendance: " . $conn->error;
        }
    } else {
        $error_message = "Invalid QR code";
    }
} else {
    $error_message = "No QR code content found";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process QR Code</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
   

</head>
<body>
    <div class="container">
        <h2>Process QR Code</h2>
        <?php if(isset($error_message)) echo '<div class="alert alert-danger">'.$error_message.'</div>'; ?>
        <?php if(isset($success_message)) echo '<div class="alert alert-success">'.$success_message.'</div>'; ?>
        <a href="mark_attendance.php" class="btn btn-primary">Back to Attendance</a>
    </div>
</body>
</html>
