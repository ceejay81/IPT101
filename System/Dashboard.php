<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "db_connect.php";

// Prepare a select statement
$sql = "SELECT student_id, fullname FROM ipt102_db WHERE id = ?";

if($stmt = $mysqli->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("i", $param_id);

    // Set parameters
    $param_id = $_SESSION["id"];

    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Store result
        $stmt->store_result();
        
        // Check if student exists, if yes then fetch the student details
        if($stmt->num_rows == 1){                    
            // Bind result variables
            $stmt->bind_result($student_id, $fullname);
            if($stmt->fetch()){
                // Display student information
                echo "<h1>Welcome, " . $fullname . "!</h1>";
                echo "<p>Your Student ID: " . $student_id . "</p>";
                
                // Provide options for the student to navigate further
                echo "<p><a href='assessments.php'>Take Assessments</a></p>";
                echo "<p><a href='evaluations.php'>View Evaluations</a></p>";
                echo "<p><a href='logout.php'>Logout</a></p>";
            }
        } else{
            // Student not found, redirect to login page
            header("location: login.php");
            exit;
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$mysqli->close();
?>
