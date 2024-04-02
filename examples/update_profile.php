<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    $requiredFields = ['full_name', 'email', 'phone_number', 'address', 'password', 'education', 'location', 'skills', 'notes', 'experience'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            // If any required field is empty, return an error response
            http_response_code(400);
            echo json_encode(array("error" => "All fields are required."));
            exit;
        }
    }

    // Database connection credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user1";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("UPDATE user_profile SET full_name=?, email=?, phone_number=?, address=?, password=?, education=?, location=?, skills=?, notes=?, experience=?, profile_picture=? WHERE user_id=?");

    // Bind parameters
    
    $stmt->bind_param("sssssssssssi", $full_name, $email, $phone_number, $address, $password, $education, $location, $skills, $notes, $experience, $profilePictureUrl, $user_id);

    // Retrieve form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $education = $_POST['education'];
    $location = $_POST['location'];
    $skills = $_POST['skills'];
    $notes = $_POST['notes'];
    $experience = $_POST['experience'];
    $user_id = 1; // Assuming the user ID is 1 for now

    // Check if profile picture is uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        // Handle file upload
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
            // File uploaded successfully
            $profilePictureUrl = $uploadFile;
        } else {
            // Error occurred while uploading file
            http_response_code(500);
            echo json_encode(array("error" => "Failed to upload profile picture."));
            exit;
        }
    } else {
        // No profile picture uploaded
        $profilePictureUrl = ""; // Set default or existing profile picture URL
    }

    // Execute SQL statement
    if ($stmt->execute()) {
        // Return success response with updated profile information
        http_response_code(200);
        echo json_encode(array(
            "full_name" => $full_name,
            "email" => $email,
            "phone_number" => $phone_number,
            "address" => $address,
            "education" => $education,
            "location" => $location,
            "skills" => $skills,
            "notes" => $notes,
            "experience" => $experience,
            "profile_picture" => $profilePictureUrl // Return profile picture URL
        ));
    } else {
        // Return error response if database error occurs
        http_response_code(500);
        echo json_encode(array("error" => "Database error: " . $stmt->error));
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

} else {
    // If request method is not POST, return an error response
    http_response_code(405);
    echo json_encode(array("error" => "Method Not Allowed"));
}
?>
