<?php 
session_start();
include "db_connect.php";

// Retrieve email and code parameters from the URL or set them to empty strings if not present
$email = isset($_GET['email']) ? $_GET['email'] : '';
$code = isset($_GET['code']) ? $_GET['code'] : '';

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if email and code are set and not empty
    if (!empty($email) && !empty($code)) {
        // Check if email and code match a record in the users_verification table
        $verification_check_sql = "SELECT * FROM users_verification WHERE email = '$email' AND verification_code = '$code'";
        
        // Execute the SQL query
        $verification_check_result = mysqli_query($conn, $verification_check_sql);
        
        // Check for errors
        if (!$verification_check_result) {
            echo "Error: " . mysqli_error($conn);
            exit();
        }

        if (isset($email) && isset($code)) {
            if (mysqli_num_rows($verification_check_result) > 0) {
                // Update verification status to 'Verified' in users_verification table
                $update_verification_sql = "UPDATE users_verification SET verification_status = 'Verified' WHERE email = '$email'";
                $update_verification_result = mysqli_query($conn, $update_verification_sql);

                if ($update_verification_result) {
                    // Redirect to a success page
                    header("Location: verified.php");
                    exit();
                } else {
                    // Display error message if verification status update fails
                    echo "Failed to update verification status. Please try again.";
                }
            } else {
                // Display error message if email and code don't match any record
                echo "Invalid verification link. Please try again.";
            }
        } else {
            // Display error message if email and code are not set
            echo "Invalid verification link. Please try again.";
        }
    }
}
?>

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .error-message {
            margin-top: 20vh;
            font-size: 24px;
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if (!empty($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } elseif (!empty($message)) { ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php } else { ?>
        <div class="error-message">
            <?php echo "Invalid verification link. Please try again."; ?>
        </div>
    <?php } ?>
    <div class="mt-3 text-center">
        <p>Return to <a href="login.php">Login</a></p>
    </div>
</div>
</body>
</html>
