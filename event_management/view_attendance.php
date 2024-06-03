<?php
include('config/database.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch attendance data
$sql = "SELECT attendance.id, users.name AS user_name, events.name AS event_name, attendance.attendance_time
        FROM attendance
        INNER JOIN users ON attendance.user_id = users.id
        INNER JOIN events ON attendance.event_id = events.id";

$result = mysqli_query($conn, $sql);

// Check if query was successful
if (!$result) {
    die('Error fetching attendance data: ' . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini sidebar-collapsed">
    <div class="wrapper">
    <?php include('includes/sidebar.php'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>View Attendance</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Attendance Records</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Event Name</th>
                                        <th>Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['user_name']; ?></td>
                                            <td><?php echo $row['event_name']; ?></td>
                                            <td><?php echo $row['timestamp']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    <script>
        $(document).ready(function () {
            $('[data-widget="pushmenu"]').click(function () {
                $("body").toggleClass('sidebar-collapse sidebar-mini')
            });
        });
    </script>

</body>
</html>
