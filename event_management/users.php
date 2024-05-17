<?php
include('config.php');
require 'vendor/autoload.php';
require 'vendor\endroid\qrcode\src\Writer';

use Endroid\QrCode\QrCode;

if (isset($_POST['add_user'])) {
    // Sanitize user inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }

    // Generate QR code
    $qrCode = new QrCode($email);
    $qrCode->setSize(300); // Set the size of the QR code

    // Generate QR code image and save to file
    $qrFilename = 'qr_codes/' . $email . '.png';
    $qrCode->writeFile($qrFilename);

    // Prepare SQL statement with parameterized query to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (name, email, qr_code) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $qrFilename);

    if ($stmt->execute()) {
        echo "User added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link rel="stylesheet" href="styles.css"> 
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include('navbar.php'); ?>
    <?php include('sidebar.php'); ?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Users</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <form method="post" action="users.php">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add_user">Add User</button>
                        </form>
                    </div>
                </div>
                <div class="row mt-4">
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
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
