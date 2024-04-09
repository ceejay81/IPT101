<?php
require_once "dashboard_backend.php";
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
    <link rel="stylesheet" href="style.css">
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
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user"></i>
                        <span class="d-none d-md-inline"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">Profile</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item" id="load-profile">
                            <i class="fas fa-user mr-2"></i> View Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="logout.php" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Sign out
                        </a>
                    </div>
                </li>
                <!-- /.User Dropdown Menu -->
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
                            <a href="#" class="nav-link active" id="load-home">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <!-- Profile -->
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="load-profile">
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
                        <!-- Evaluations -->
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="load-evaluations">
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
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- Rest of the content -->
                    <!-- Welcome message -->
                    <div id="home-container" class="content">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Dashboard</h1>
                            </div>
                            <div class="col-sm-6 d-flex align-items-center justify-content-center">
                                <p class="welcome-message text-center">Welcome, <?php echo $user['first_name'] . ' ' . $user['last_name'] . ', Student ID: ' . $user['student_id']; ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Summary -->
                    <div id="profile-container" class="content" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Profile Summary</h3>
                            </div>
                            <div class="card-body">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="middle_name" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo $user['middle_name']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="profile_picture" class="form-label">Upload Profile Picture</label>
                                        <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                                    </div>
                                    <button type="submit" name="submit_profile" class="btn btn-primary">Submit</button>
                                </form>
                                <?php if (!empty($error_message)) : ?>
                                    <div class="alert alert-danger mt-3" role="alert"><?php echo $error_message; ?></div>
                                <?php elseif (!empty($success_message)) : ?>
                                    <div class="alert alert-success mt-3" role="alert"><?php echo $success_message; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Assessments Dashboard -->
                    <div id="assessments-container" class="content" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Assessments Dashboard</h3>
                            </div>
                            <div class="card-body">
                                <!-- Assessments Form -->
                                <form class="row g-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="col-md-5">
                                        <label for="assess_name" class="form-label">Assessment Name:</label>
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
                                        <button type="submit" name="submit_assessment" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                <!-- /.Assessments Form -->
                            </div>
                        </div>
                    </div>

                    <!-- Evaluation Results -->
                    <div id="evaluations-container" class="content" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Evaluation Results</h3>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($assessment_results)) : ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Assessment Name</th>
                                                <th>Date</th>
                                                <th>Subject ID</th>
                                                <th>Assessment Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($assessment_results as $assessment) : ?>
                                                <tr>
                                                    <td><?php echo $assessment['assess_name']; ?></td>
                                                    <td><?php echo $assessment['date']; ?></td>
                                                    <td><?php echo $assessment['subject_id']; ?></td>
                                                    <td><?php echo $assessment['assess_type']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <p>No evaluation results found.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
    <script>
       $(document).ready(function () {
    // Function to load home content when the "Home" link is clicked
    $("#load-home").click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        // Show home content and hide others
        console.log("Home link clicked");
        $("#home-container").show();
        $("#profile-container").hide();
        $("#assessments-container").hide();
        $("#evaluations-container").hide();
    });

    // Function to load profile content when the "Profile" link is clicked
    $("#load-profile").click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        // Show profile content and hide others
        console.log("Profile link clicked");
        $("#home-container").hide();
        $("#profile-container").show();
        $("#assessments-container").hide();
        $("#evaluations-container").hide();
    });

    // Function to load assessments content when the "Assessments" link is clicked
    $("#load-assessments").click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        // Show assessments content and hide others
        console.log("Assessments link clicked");
        $("#home-container").hide();
        $("#profile-container").hide();
        $("#assessments-container").show();
        $("#evaluations-container").hide();
    });

    // Function to load evaluations content when the "Evaluations" link is clicked
    $("#load-evaluations").click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        // Show evaluations content and hide others
        console.log("Evaluations link clicked");
        $("#home-container").hide();
        $("#profile-container").hide();
        $("#assessments-container").hide();
        $("#evaluations-container").show();
    });
});

    </script>
</body>

</html>
