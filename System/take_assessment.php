<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Check if assessment ID is provided in the URL
if (!isset($_GET["id"]) || empty(trim($_GET["id"]))) {
    header("location: assessments.php");
    exit;
}

// Prepare a SQL statement to fetch the assessment details
$sql = "SELECT name, questions FROM assessments WHERE id = ?";

if ($stmt = $mysqli->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("i", $param_id);

    // Set parameters
    $param_id = trim($_GET["id"]);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Store result
        $stmt->store_result();

        // Check if assessment exists
        if ($stmt->num_rows == 1) {
            // Bind result variables
            $stmt->bind_result($name, $questions_json);
            $stmt->fetch();

            // Decode JSON string to array
            $questions = json_decode($questions_json, true);
        } else {
            // Redirect to assessments page if assessment ID is invalid
            header("location: assessments.php");
            exit;
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
    <title>Take Assessment - <?php echo $name; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <h2>Take Assessment - <?php echo $name; ?></h2>
        <form action="submit_assessment.php" method="post">
            <?php foreach ($questions as $index => $question) : ?>
                <div class="question">
                    <p><?php echo $question["text"]; ?></p>
                    <?php foreach ($question["options"] as $option) : ?>
                        <input type="radio" name="answers[<?php echo $index; ?>]" value="<?php echo $option; ?>"><?php echo $option; ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <input type="submit" value="Submit">
        </form>
        <p><a href="assessments.php">Back to Assessments</a></p>
    </div>
</body>
</html>
