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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_event'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $venue = mysqli_real_escape_string($conn, $_POST['venue']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        $update_sql = "UPDATE events SET name='$name', date='$date', time='$time', venue='$venue', description='$description' WHERE id=$id";
        if (mysqli_query($conn, $update_sql)) {
            header("Location: events.php");
            exit();
        } else {
            $error_message = "Error: " . $update_sql . "<br>" . mysqli_error($conn);
        }
    }
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
    <title>Update Event</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">


</head>
<body class="hold-transition sidebar-mini sidebar-collapsed">
    <div class="wrapper">
    <?php include('includes/sidebar.php'); ?>
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Update Event</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Event Details</h3>
                        </div>
                        <form method="POST" action="update_event.php?id=<?php echo $id; ?>">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Event Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $event['name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" value="<?php echo $event['date']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="time">Time</label>
                                    <input type="time" class="form-control" id="time" name="time" value="<?php echo $event['time']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="venue">Venue</label>
                                    <input type="text" class="form-control" id="venue" name="venue" value="<?php echo $event['venue']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" required><?php echo $event['description']; ?></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="update_event">Update Event</button>
                            </div>
                        </form>
                        <?php if (isset($error_message)) echo '<div class="alert alert-danger">' . $error_message . '</div>'; ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
   

</body>
</html>
