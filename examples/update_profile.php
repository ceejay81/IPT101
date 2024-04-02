<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input fields
    $errors = array();

    // Validate required fields
    $requiredFields = array('full_name', 'email', 'phone_number', 'address', 'password', 'education', 'location', 'skills', 'notes', 'experience');
    foreach ($requiredFields as $field) {
        if (empty(trim($_POST[$field]))) {
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
        }
    }

    // Validate email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {  
        $errors['email'] = 'Invalid email format.';
    }

    // Validate phone number (example: 123-456-7890)
    if (!preg_match('/^\d{3}-\d{3}-\d{4}$/', $_POST['phone_number'])) {
        $errors['phone_number'] = 'Invalid phone number format (e.g., 123-456-7890).';
    }

    // Check if there are any errors
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(array("error" => $errors));
        exit;
    }

    // Proceed with database operations if validation passes

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

    // Handle profile picture upload
    $profilePictureUrl = ''; // Default profile picture URL
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
            $profilePictureUrl = $uploadFile;
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "Failed to upload profile picture."));
            exit;
        }
    }

    // Prepare and execute SQL statement for insertion or update based on user_id
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        // Update existing record
        $stmt = $conn->prepare("UPDATE user_profile SET full_name=?, email=?, phone_number=?, address=?, password=?, education=?, location=?, skills=?, notes=?, experience=?, profile_picture=? WHERE user_id=?");
        $stmt->bind_param("sssssssssssi", $full_name, $email, $phone_number, $address, $password, $education, $location, $skills, $notes, $experience, $profilePictureUrl, $user_id);
        $user_id = $_POST['user_id'];
    } else {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO user_profile (full_name, email, phone_number, address, password, education, location, skills, notes, experience, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $full_name, $email, $phone_number, $address, $password, $education, $location, $skills, $notes, $experience, $profilePictureUrl);
    }
    
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

    // Execute SQL statement
    try {
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
    } catch (Exception $e) {
        // Handle other exceptions
        http_response_code(500);
        echo json_encode(array("error" => "An error occurred: " . $e->getMessage()));
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
