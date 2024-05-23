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
        // Prepare the SQL statement to prevent SQL injection
        $verification_check_sql = "SELECT * FROM users_verification WHERE email = ? AND verification_code = ?";
        $stmt = $conn->prepare($verification_check_sql);
        $stmt->bind_param("ss", $email, $code);
        
        // Execute the prepared statement
        $stmt->execute();
        $verification_check_result = $stmt->get_result();

        // Check for errors
        if ($verification_check_result === false) {
            error_log("Database query error: " . $conn->error);
            echo "An error occurred. Please try again later.";
            exit();
        }

        if ($verification_check_result->num_rows > 0) {
            // Update verification status to 'Verified' in users_verification table
            $update_verification_sql = "UPDATE users_verification SET verification_status = 'Verified' WHERE email = ?";
            $update_stmt = $conn->prepare($update_verification_sql);
            $update_stmt->bind_param("s", $email);
            $update_verification_result = $update_stmt->execute();

            if ($update_verification_result) {
                // Update status and active fields in ipt102_db table
                $update_user_sql = "UPDATE ipt102_db SET status = 'Verified', active = 1 WHERE email = ?";
                $update_user_stmt = $conn->prepare($update_user_sql);
                $update_user_stmt->bind_param("s", $email);
                $update_user_result = $update_user_stmt->execute();

                if ($update_user_result) {
                    // Redirect to a success page
                    header("Location: verified.php");
                    exit();
                } else {
                    error_log("Failed to update user status and active: " . $conn->error);
                    echo "Failed to update user status and active. Please try again.";
                }
            } else {
                error_log("Failed to update verification status: " . $conn->error);
                echo "Failed to update verification status. Please try again.";
            }
        } else {
            // Display error message if email and code don't match any record
            display_error_message();
        }
    } else {
        // Display error message if email and code are not set
        display_error_message();
    }
}

function display_error_message() {
    echo <<<HTML
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
    <div class="error-message">
        Invalid verification link. Please try again.
    </div>
    <div class="mt-3 text-center">
        <p>Return to <a href="login.php">Login</a></p>
    </div>
</div>
</body>
</html>
HTML;
    exit();
}
?>
