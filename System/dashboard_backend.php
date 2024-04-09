<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "db_connect.php";

// Fetch user's profile information from the database
$id = $_SESSION["id"];
$query = "SELECT * FROM ipt102_db WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error retrieving user data: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

// Process form submission for assessments
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_assessment'])) {
        // Check if assessment name is provided
        if (empty($_POST['assess_name'])) {
            $error_message = "Please fill out the assessment name.";
        } else {
            // Sanitize input data
            $assess_name = mysqli_real_escape_string($conn, $_POST["assess_name"]);
            $date = mysqli_real_escape_string($conn, $_POST["date"]);
            $subject_id = mysqli_real_escape_string($conn, $_POST["subject_id"]);
            $assess_type = mysqli_real_escape_string($conn, $_POST["assess_type"]);

            // Insert assessment data into the database
            $insert_query = "INSERT INTO assessments (assess_name, date, subject_id, assess_type) VALUES ('$assess_name', '$date', '$subject_id', '$assess_type')";
            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                $success_message = "Assessment data submitted successfully.";
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        }
    }
}
// Process form submission for profile editing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_profile'])) {
        // Retrieve form data
        $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
        $middle_name = mysqli_real_escape_string($conn, $_POST["middle_name"]);
        $last_name = mysqli_real_escape_string($conn, $_POST["last_name"]);

        // Update user's profile information in the database
        $update_query = "UPDATE ipt102_db SET first_name = '$first_name', middle_name = '$middle_name', last_name = '$last_name' WHERE id = $id";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            $success_message = "Profile information updated successfully.";
            // Update the user variable to reflect the changes
            $user['first_name'] = $first_name;
            $user['middle_name'] = $middle_name;
            $user['last_name'] = $last_name;
        } else {
            $error_message = "Error updating profile: " . mysqli_error($conn);
        }
    }
}
// Process file upload for profile picture
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_profile_picture'])) {
        $target_dir = "uploads/"; // Directory where the file will be stored
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]); // Path of the uploaded file
        $uploadOk = 1; // Flag to check if the upload is successful
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // File extension

        // Check if the file is an image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            // Allow only certain file formats (you can adjust this as needed)
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $error_message = "Sorry, only JPG, JPEG, PNG files are allowed.";
                $uploadOk = 0;
            }
        } else {
            $error_message = "File is not an image.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error_message = "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                // Update user's profile picture path in the database
                $profile_picture_path = mysqli_real_escape_string($conn, $target_file);
                $update_picture_query = "UPDATE ipt102_db SET profile_picture = '$profile_picture_path' WHERE id = $id";
                $update_picture_result = mysqli_query($conn, $update_picture_query);

                if ($update_picture_result) {
                    $success_message = "Profile picture uploaded successfully.";
                    // Update the user variable to reflect the changes
                    $user['profile_picture'] = $profile_picture_path;
                } else {
                    $error_message = "Error updating profile picture: " . mysqli_error($conn);
                }
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    }
}


// Fetch assessment results from the database
$assessment_query = "SELECT * FROM assessments WHERE id = $id";
$assessment_result = mysqli_query($conn, $assessment_query);

if (!$assessment_result) {
    $error_message = "Error retrieving assessment results: " . mysqli_error($conn);
} else {
    // Store assessment results in an array
    $assessment_results = [];
    while ($row = mysqli_fetch_assoc($assessment_result)) {
        $assessment_results[] = $row;
    }
}



?>
