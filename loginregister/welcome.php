<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include_once 'db_connect.php';

$email = $_SESSION['email'];

$sql = "SELECT * FROM ipt102_db WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
        <h2>Welcome, <?php echo $email; ?>!</h2>
        <p>Here are your details:</p>
        <ul>
            <li>First Name: <?php echo $row['first_name']; ?></li>
            <li>Last Name: <?php echo $row['last_name']; ?></li>
            <li>Middle Name: <?php echo $row['middle_name']; ?></li>
            <li>Email: <?php echo $row['email']; ?></li>
        </ul>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
