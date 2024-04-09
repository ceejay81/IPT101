<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "db_connect.php";

// Fetch user's profile information from the database
$id = $_SESSION["id"];
$query = "SELECT * FROM ipt102_db WHERE id = $id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">School System</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <!-- Home -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>

                        <!-- Profile -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>
                        <!-- Assessments -->
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="load-assessments">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Assessments</p>
                            </a>
                        </li>
                        <!-- /. Assessments -->

                        <!-- Evaluations -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-star"></i>
                                <p>
                                    Evaluations
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- Profile Summary -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Profile Summary</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> <?php echo $user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['last_name']; ?></p>
                            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                            <!-- Add more profile information as needed -->
                        </div>
                    </div>

                    <!-- Assessment Dashboard -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Assessment Dashboard</h3>
                        </div>
                        <div class="card-body">
                            <!-- Assessments Form -->
                            <form class="row g-3" method="post" action="submit.php">
                                <div class="col-md-5">
                                    <label for="inputEmail4" class="form-label">Assessment Name:</label>
                                    <input name="assess_name" class="form-control" id="assess_name">
                                </div>
                                <div class="col-md-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" name="date" class="form-control" id="date">
                                </div>
                                <div class="col-md-2">
                                    <label for="subject_id" class="form-label">Subject ID</label>
                                    <select name="subject_id" id="subject_id" class="form-select">
                                        <option>ENG101</option>
                                        <option>MATH201</option>
                                        <option>SCI301</option>
                                        <option>HIS202</option>
                                        <option>CS150</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="assess_type" class="form-label">Assessment Type</label>
                                    <select name="assess_type" id="assess_type" class="form-select">
                                        <option>Test</option>
                                        <option>Quiz</option>
                                        <option>Exam</option>
                                        <option>Presentation</option>
                                        <option>Project</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button name="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            <!-- /.Assessments Form -->
                        </div>
                    </div>

                    <!-- Evaluation Results -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Evaluation Results</h3>
                        </div>
                        <div class="card-body">
                            <p>Track your progress and performance over time.</p>
                        </div>
                    </div>

                    <!-- Actionable Insights -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Actionable Insights</h3>
                        </div>
                        <div class="card-body">
                            <p>Identify areas for improvement and take targeted actions to enhance your learning experience.</p>
                        </div>
                    </div>

                    <!-- Settings and Preferences -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Settings and Preferences</h3>
                        </div>
                        <div class="card-body">
                            <p>Customize your dashboard experience according to your preferences.</p>
                        </div>
                    </div>

                    <!-- Logout -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Logout</h3>
                        </div>
                        <div class="card-body">
                            <p>Click here to securely log out of your account.</p>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.content -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <div class="float-right d-none d-sm-inline">
                    Version 1.0
                </div>
                <strong>&copy; 2024 School System</strong>
            </footer>
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to load assessments content when the "Assessments" link is clicked
            $("#load-assessments").click(function (e) {
                e.preventDefault(); // Prevent the default link behavior

                // AJAX request to load assessments.php content
                $.ajax({
                    url: "assessments.php",
                    success: function (data) {
                        // Replace the content of #assessments-container with the loaded content
                        $("#assessments-container").html(data);
                    }
                });
            });
        });
    </script>
</body>

</html>
