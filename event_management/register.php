<?php
session_start();

// Include database connection
include('config/database.php');

// Process registration form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Retrieve and sanitize form data
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = 'teacher';

    // Insert teacher data into database
    $sql = "INSERT INTO users (role, fullname, email, password) VALUES ('$role', '$fullname', '$email', '$password')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success_message'] = "Registration successful. Please log in.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . mysqli_error($conn);
        header("Location: register.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .register-page {
            background: #f4f6f9;
        }
        .register-box {
            width: 500px;
            margin: auto;
            margin-top: 5%;
        }
        .register-box-body {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }
        .register-footer {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-box-body">
            <h2 class="register-box-msg">Teacher Registration</h2>
            <form action="register.php" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Full Name" name="fullname" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
                <!-- Hidden role field -->
                <input type="hidden" name="role" value="teacher">
                <button type="submit" class="btn btn-primary btn-block" name="register">Register</button>
            </form>
            <div class="register-footer">
                <a href="login.php" class="text-center">Already have an account? Login here.</a>
            </div>
        </div>
    </div>
</body>
</html>
