<?php 
 
// Include configuration file 
require_once 'db_connect.php'; 
 
// Remove token and user data from the session 
unset($_SESSION['token']); 
unset($_SESSION['userData']); 
 
// Destroy entire session data 
session_destroy(); 
 
// Redirect to homepage 
header("Location: index.php"); 
exit(); 
 
?>