<?php
// Include the QRcode library
require_once 'phpqrcode/qrlib.php';

// Function to generate QR code
function generateQRCode($user_id, $email) {
    // Generate QR code data (e.g., user ID or email)
    $qr_code_data = "User ID: $user_id\nEmail: $email";
    
    // Define the file path for the QR code image
    $file_path = "assets/images/qrcodes/$user_id.png";

    // Generate QR code image
    QRcode::png($qr_code_data, $file_path, QR_ECLEVEL_L, 10);

    // Return the file path
    return $file_path;
}

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include('config/database.php');

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Generate QR code for the user
$qr_code_file = generateQRCode($user['id'], $user['email']);

// Set flash message
$_SESSION['flash_message'] = "QR code generated successfully.";

// Redirect back to dashboard with QR code filename as a query parameter
header("Location: dashboard.php?qr_code_file=" . urlencode($qr_code_file));
exit();
?>
