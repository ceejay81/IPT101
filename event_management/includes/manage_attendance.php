<?php
session_start();
include('../config/database.php');

// Check if user is authenticated as a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

$errors = array();
$debug_messages = array(); // Debug messages array

// Fetch teacher information
$teacher_id = $_SESSION['user_id'];
$sql = "SELECT fullname, email FROM users WHERE id = '$teacher_id' AND role = 'teacher'";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    // Redirect if teacher information not found
    header("Location: teacher_dashboard.php");
    exit();
}
$teacher = mysqli_fetch_assoc($result);

// Fetch events
$sql = "SELECT * FROM events WHERE teacher_id = '$teacher_id'";
$events_result = mysqli_query($conn, $sql);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate event ID
    $event_id = $_POST['event_id'];
    if (empty($event_id)) {
        $errors['event_id'] = "Event ID is required";
    } elseif (!is_numeric($event_id)) {
        $errors['event_id'] = "Event ID must be a number";
    }

    // Handle attendance submission
    if (isset($_POST['attendance'])) {
        $student_attendance = $_POST['attendance'];

        foreach ($student_attendance as $student_id => $status) {
            // Validate student ID
            if (empty($student_id)) {
                $errors['student_id'] = "Student ID is required";
            } elseif (!is_numeric($student_id)) {
                $errors['student_id'] = "Student ID must be a number";
            } else {
                // Check if the student exists and has a role of 'student'
                $check_student_query = "SELECT * FROM students WHERE student_id = '$student_id' AND teacher_id = '$teacher_id'";
                $check_student_result = mysqli_query($conn, $check_student_query);

                // Debug message
                $debug_messages[] = "Checking student ID: $student_id";

                if (mysqli_num_rows($check_student_result) == 0) {
                    $errors['student_id'] = "Invalid student ID or not enrolled as a student";
                    $debug_messages[] = "Invalid student ID or not enrolled as a student for ID: $student_id";
                }
            }

            // Insert attendance record if no errors
            if (empty($errors)) {
                // Check if attendance record already exists
                $check_attendance_query = "SELECT * FROM attendance WHERE event_id = '$event_id' AND student_id = '$student_id'";
                $check_attendance_result = mysqli_query($conn, $check_attendance_query);
                if (mysqli_num_rows($check_attendance_result) > 0) {
                    $errors['duplicate'] = "Attendance record already exists for student ID $student_id in event ID $event_id";
                } else {
                    // Insert attendance record
                $sql = "INSERT INTO attendance (event_id, student_id, status) VALUES ('$event_id', '$student_id', '$status')";
                if (!mysqli_query($conn, $sql)) {
                    // Error handling
                    echo "Error: " . mysqli_error($conn);
                } else {
                    // Success message or further processing
                    echo "Attendance record inserted successfully.";
                }

                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attendance</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">Teacher Dashboard</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="teacher_dashboard.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="add_event.php" class="nav-link">
                            <i class="nav-icon fas fa-calendar-plus"></i>
                            <p>Add Event</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="view_events.php" class="nav-link">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>View Events</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_attendance.php" class="nav-link">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>Manage Attendance</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="enroll_student.php" class="nav-link">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>Enroll Student</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="view_students.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>View Students</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="view_attendance.php" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>View Attendance</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-6">Manage Attendance</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Manage Attendance</h5>
                                    <!-- Attendance Form -->
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="event_id">Select Event:</label>
                                            <select class="form-control" id="event_id" name="event_id">
                                                <option value="">Select Event</option>
                                                <?php while ($event = mysqli_fetch_assoc($events_result)) : ?>
                                                    <option value="<?php echo $event['id']; ?>"><?php echo $event['name']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        
                                        <!-- Attendance checkboxes dynamically generated based on students -->
                                        <?php
                                        // Fetch students associated with the teacher
                                        $sql = "SELECT student_id, fullname FROM students WHERE teacher_id = '$teacher_id'";
                                        $students_result = mysqli_query($conn, $sql);
                                        ?>
                                        <?php while ($student = mysqli_fetch_assoc($students_result)) : ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="attendance_<?php echo $student['student_id']; ?>" name="attendance[<?php echo $student['student_id']; ?>]" value="Present">
                                                <label class="form-check-label" for="attendance_<?php echo $student['student_id']; ?>"><?php echo $student['fullname']; ?> (ID: <?php echo $student['student_id']; ?>)</label>
                                            </div>
                                        <?php endwhile; ?>

                                        <button type="submit" class="btn btn-primary mt-3">Submit Attendance</button>
                                    </form>

                                    <!-- Display form errors -->
                                    <?php if (!empty($errors)) : ?>
                                        <div class="alert alert-danger mt-3">
                                            <ul>
                                                <?php foreach ($errors as $error) : ?>
                                                    <li><?php echo $error; ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include '../includes/footer.php'; ?>
</div>
<!-- ./wrapper -->

<!-- AdminLTE JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

</body>
</html>

