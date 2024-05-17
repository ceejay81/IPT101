<?php
include('config.php');
if (isset($_POST['scan_qr'])) {
    $email = $_POST['email'];
    $event_id = $_POST['event_id'];
    $sql = "SELECT id FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
        $sql = "INSERT INTO attendance (user_id, event_id) VALUES ('$user_id', '$event_id')";
        if ($conn->query($sql) === TRUE) {
            echo "Attendance recorded successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "User not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Scan QR Code</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link rel="stylesheet" href="styles.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
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
                        <h1 class="m-0">Scan QR Code</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <form method="post" action="scan.php">
                            <div class="form-group">
                                <label for="event_id">Event</label>
                                <select class="form-control" id="event_id" name="event_id" required>
                                    <?php
                                    $sql = "SELECT * FROM events";
                                    $result = $conn->query($sql);
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="qr_code">QR Code</label>
                                <input type="text" class="form-control" id="qr_code" name="qr_code" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="scan_qr">Record Attendance</button>
                        </form>
                        <video id="preview"></video>
                        <script type="text/javascript">
                            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                            scanner.addListener('scan', function (content) {
                                document.getElementById('qr_code').value = content;
                            });
                            Instascan.Camera.getCameras().then(function (cameras) {
                                if (cameras.length > 0) {
                                    scanner.start(cameras[0]);
                                } else {
                                    console.error('No cameras found.');
                                }
                            }).catch(function (e) {
                                console.error(e);
                            });
                        </script>
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
