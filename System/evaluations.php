<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Fetch evaluations from the database for the logged-in student
$sql = "SELECT a.name AS assessment_name, ar.score 
        FROM assessment_results ar
        JOIN assessments a ON ar.assessment_id = a.id
        WHERE ar.student_id = ?";

if ($stmt = $mysqli->prepare($sql)) {
    // Bind variable to the prepared statement as parameter
    $stmt->bind_param("i", $_SESSION["id"]);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Store result
        $stmt->store_result();

        // Check if there are any evaluations
        if ($stmt->num_rows > 0) {
            // Bind result variables
            $stmt->bind_result($assessment_name, $score);

            // Initialize array to store evaluations
            $evaluations = array();

            // Fetch evaluations and store them in the array
            while ($stmt->fetch()) {
                $evaluations[] = array("assessment_name" => $assessment_name, "score" => $score);
            }
        } else {
            // No evaluations found
            $evaluations = array();
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluations</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <h2>Evaluations</h2>
        <?php if (!empty($evaluations)) : ?>
            <table>
                <tr>
                    <th>Assessment</th>
                    <th>Score</th>
                </tr>
                <?php foreach ($evaluations as $evaluation) : ?>
                    <tr>
                        <td><?php echo $evaluation['assessment_name']; ?></td>
                        <td><?php echo $evaluation['score']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No evaluations found.</p>
        <?php endif; ?>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
