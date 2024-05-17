<?php
include('config.php');
if (isset($_POST['add_event'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];
    $description = $_POST['description'];
    $sql = "INSERT INTO events (name, date, time, venue, description) VALUES ('$name', '$date', '$time', '$venue', '$description')";
    if ($conn->query($sql) === TRUE) {
        echo "Event added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Events</title>
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
                        <h1 class="m-0">Events</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <form method="post" action="events.php">
                            <div class="form-group">
                                <label for="name">Event Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="time">Time</label>
                                <input type="time" class="form-control" id="time" name="time" required>
                            </div>
                            <div class="form-group">
                                <label for="venue">Venue</label>
                                <input type="text" class="form-control" id="venue" name="venue" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add_event">Add Event</button>
                        </form>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h3>All Events</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Venue</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM events";
                                $result = $conn->query($sql);
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>".$row['name']."</td>
                                            <td>".$row['date']."</td>
                                            <td>".$row['time']."</td>
                                            <td>".$row['venue']."</td>
                                            <td>".$row['description']."</td>
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
