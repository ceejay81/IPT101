<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Fetch assessments from the database
// You would need to implement this part based on how your assessments are stored in the database

// Example of fetching assessments
$assessments = array(
    array("id" => 1, "name" => "Math Assessment"),
    array("id" => 2, "name" => "English Assessment"),
    // Add more assessments as needed
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessments</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <h2>Available Assessments</h2>
        <p>Select an assessment to take:</p>
        <ul>
            <?php foreach($assessments as $assessment): ?>
                <li><a href="take_assessment.php?id=<?php echo $assessment['id']; ?>"><?php echo $assessment['name']; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
