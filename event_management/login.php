<?php
session_start();
include('config/database.php');

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $role = $_POST['role'];
    $email_or_id = mysqli_real_escape_string($conn, $_POST['email_or_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    if ($role == 'teacher') {
        $sql = "SELECT * FROM users WHERE email = '$email_or_id' AND role = 'teacher'";
    } else {
        $sql = "SELECT * FROM users WHERE student_id = '$email_or_id' AND role = 'student'";
    }

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if ($password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            if ($role == 'teacher') {
                header("Location: includes/teacher_dashboard.php");
            } else {
                header("Location: student_dashboard.php");
            }
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with the provided email or ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .role-selection {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .role-selection button {
            width: 50%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .role-selection button.teacher {
            background-color: #007bff;
            color: #fff;
            margin-right: 10px;
        }
        .role-selection button.student {
            background-color: #28a745;
            color: #fff;
        }
        .role-selection button.active {
            background-color: #0056b3;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>User</b>Login</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <?php if (!empty($error_message)) echo '<div class="alert alert-danger">'.$error_message.'</div>'; ?>
                <form action="login.php" method="POST">
                    <input type="hidden" name="role" id="role" value="teacher">
                    <div class="role-selection">
                        <button type="button" class="teacher active" onclick="setRole('teacher')">Teacher</button>
                        <button type="button" class="student" onclick="setRole('student')">Student</button>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="email_or_id" name="email_or_id" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" name="login">Sign In</button>
                        </div>
                    </div>
                </form>
                <div class="register-footer text-center mt-3">
                    <a href="register.php" class="text-center">New here? Register now.</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setRole(role) {
            document.getElementById('role').value = role;
            document.querySelectorAll('.role-selection button').forEach(btn => btn.classList.remove('active'));
            if (role === 'teacher') {
                document.getElementById('email_or_id').placeholder = 'Email';
                document.querySelector('.role-selection button.teacher').classList.add('active');
            } else {
                document.getElementById('email_or_id').placeholder = 'Student ID';
                document.querySelector('.role-selection button.student').classList.add('active');
            }
        }
    </script>
</body>
</html>
