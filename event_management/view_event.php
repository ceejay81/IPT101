<?php
include('config/database.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM events WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $event = mysqli_fetch_assoc($result);
} else {
    header("Location: events.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Event</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini sidebar-collapsed">
    <div class="wrapper">
        <!-- Include Sidebar Here -->
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>View Event</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Event Details</h3>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">Event Name</dt>
                                <dd class="col-sm-8"><?php echo $event['name']; ?></dd>
                                <dt class="col-sm-4">Date</dt>
                                <dd class="col-sm-8"><?php echo $event['date']; ?></dd>
                                <dt class="col-sm-4">Time</dt>
                                <dd class="col-sm-8"><?php echo $event['time']; ?></dd>
                                <dt class="col-sm-4">Venue</dt>
                                <dd class="col-sm-8"><?php echo $event['venue']; ?></dd>
                                <dt class="col-sm-4">Description</dt>
                                <dd class="col-sm-8"><?php echo $event['description']; ?></dd>
                            </dl>
                        </div>
                        <div class="card-footer">
                            <a href="events.php" class="btn btn-default">Back to Events</a>
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
