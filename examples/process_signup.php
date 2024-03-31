<?php
// Check if all required form fields are set
if (isset($_POST['full_name'], $_POST['email'], $_POST['password'], $_POST['retype_password'])) {
    // Check if the terms checkbox is checked and has the correct value
    if (!isset($_POST['terms']) || $_POST['terms'] !== 'agree') {
        // Terms checkbox is not checked or has incorrect value, return an error message
        http_response_code(400); // Bad Request
        echo "You must agree to the terms to register.";
        exit(); // Stop further execution
    }

    // Process the user data
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $retypePassword = $_POST['retype_password'];

    // Perform password matching check
    if ($password !== $retypePassword) {
        // Passwords do not match, return an error message
        http_response_code(400); // Bad Request
        echo "Passwords do not match.";
        exit(); // Stop further execution
    }

    // Your database connection and insertion code here

    // Redirect to login page after successful registration
    header("Location: login.html");
    exit(); // Stop further execution
} else {
    // If any required form fields are not set, send an error response
    http_response_code(400); // Bad Request
    echo "All form fields are required.";
    exit(); // Stop further execution
}
?>
