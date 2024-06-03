<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('config/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];

    // Check if student ID exists in the database
    $sql = "SELECT * FROM users WHERE id='$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Student ID exists, mark attendance
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
        $error_message = "Invalid student ID";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
   

</head>
<body>
    <div class="container">
        <h2>Manual Attendance Entry</h2>
        <?php if(isset($error_message)) echo '<div class="alert alert-danger">'.$error_message.'</div>'; ?>
        <?php if(isset($success_message)) echo '<div class="alert alert-success">'.$success_message.'</div>'; ?>
        <form action="manual_attendance.php" method="POST">
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" class="form-control" id="student_id" name="student_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Mark Attendance</button>
        </form>
    </div>
</body>
</html>
