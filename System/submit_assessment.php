<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    if (isset($_POST["answers"])) {
        // Include config file
        require_once "config.php";

        // Get submitted answers
        $answers = $_POST["answers"];

        // Fetch correct answers from the database
        // You would need to implement this part based on how correct answers are stored in the database
        // For demonstration purposes, let's assume correct answers are stored in an array
        $correct_answers = array("A", "B", "C", "D"); // Example correct answers

        // Calculate score
        $score = 0;
        foreach ($answers as $index => $answer) {
            if ($answer == $correct_answers[$index]) {
                $score++;
            }
        }

        // Insert assessment result into database
        // You would need to implement this part based on your database structure
        // For demonstration purposes, let's assume we insert the assessment result into a table named 'assessment_results'
        $sql = "INSERT INTO assessment_results (student_id, assessment_id, score) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iii", $_SESSION["id"], $_POST["assessment_id"], $score);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Assessment result inserted successfully
                // Redirect to evaluations page
                header("location: evaluations.php");
                exit;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }

        // Close connection
        $mysqli->close();
    } else {
        // No answers submitted
        header("location: assessments.php");
        exit;
    }
} else {
    // Access method not allowed
    header("location: assessments.php");
    exit;
}
?>
