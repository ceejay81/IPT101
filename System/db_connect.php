<?php
$servername = "localhost";
$student_id = "root";
$password = "";
$database = "user1";

$conn = new mysqli($servername, $student_id, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
