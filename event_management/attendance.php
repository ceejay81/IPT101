<?php
include('config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
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
                        <h1 class="m-0">Attendance</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Attendance Records</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Event</th>
                                    <th>Attendance Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT users.name as user_name, events.name as event_name, attendance.attendance_time 
                                        FROM attendance 
                                        JOIN users ON attendance.user_id = users.id 
                                        JOIN events ON attendance.event_id = events.id";
                                $result = $conn->query($sql);
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>".$row['user_name']."</td>
                                            <td>".$row['event_name']."</td>
                                            <td>".$row['attendance_time']."</td>
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
