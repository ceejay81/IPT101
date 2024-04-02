<?php
// Retrieve form data
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$address = $_POST['address'];
$profile_picture = $_POST['profile_picture'];
$password = $_POST['password'];
$education = $_POST['education'];
$location = $_POST['location'];
$skills = $_POST['skills'];
$notes = $_POST['notes'];
$experience = $_POST['experience'];

// Connect to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind SQL statement
$stmt = $conn->prepare("INSERT INTO user_profile (full_name, email, phone_number, address, profile_picture, password, education, location, skills, notes, experience) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssss", $full_name, $email, $phone_number, $address, $profile_picture, $password, $education, $location, $skills, $notes, $experience);

// Execute SQL statement
if ($stmt->execute() === TRUE) {
    // Return JSON response with updated profile information
    $response = array(
        'full_name' => $full_name,
        'email' => $email,
        'phone_number' => $phone_number,
        'address' => $address,
        'education' => $education,
        'location' => $location,
        'skills' => $skills,
        'notes' => $notes,
        'experience' => $experience
    );
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Return error message
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
