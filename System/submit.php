<?php
session_start();

// Include config file
require_once "db_connect.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $assess_name = $_POST["assess_name"];
    $date = $_POST["date"];
    $subject_id = $_POST["subject_id"];
    $assess_type = $_POST["assess_type"];

    // Prepare SQL insert statement
    $sql = "INSERT INTO assessments (assess_name, date, subject_id, assess_type) VALUES (?, ?, ?, ?)";

    // Prepare and bind parameters
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $assess_name, $date, $subject_id, $assess_type);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Assessment submitted successfully
            $_SESSION["success_message"] = "Assessment submitted successfully.";
        } else {
            // Display error message if unable to execute SQL statement
            $_SESSION["error_message"] = "Error: Unable to submit assessment. " . $conn->error;
        }

        // Close statement
        $stmt->close();
    } else {
        // Display error message if unable to prepare SQL statement
        $_SESSION["error_message"] = "Error: Unable to prepare statement. " . $conn->error;
    }

    // Close connection
    $conn->close();
}

// Redirect to dashboard page
header("location: dashboard.php");
exit;
?>
