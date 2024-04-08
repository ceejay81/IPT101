<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "db_connect.php";

// Define variables and initialize with empty values
$new_fullname = $fullname = $new_student_id = "";
$new_fullname_err = $new_student_id_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate new full name
    if(empty(trim($_POST["new_fullname"]))){
        $new_fullname_err = "Please enter a new full name.";
    } else{
        $new_fullname = trim($_POST["new_fullname"]);
    }
    
    // Validate new student ID
    if(empty(trim($_POST["new_student_id"]))){
        $new_student_id_err = "Please enter a new student ID.";
    } else{
        $new_student_id = trim($_POST["new_student_id"]);
    }
    
    // Check input errors before updating the database
    if(empty($new_fullname_err) && empty($new_student_id_err)){
        // Prepare an update statement
        $sql = "UPDATE ipt102_db SET fullname = ?, student_id = ? WHERE id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssi", $param_fullname, $param_student_id, $param_id);
            
            // Set parameters
            $param_fullname = $new_fullname;
            $param_student_id = $new_student_id;
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Profile updated successfully, redirect to dashboard
                header("location: dashboard.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <h2>Update Profile</h2>
        <p>Please fill in the information to update your profile.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($new_fullname_err)) ? 'has-error' : ''; ?>">
                <label>New Full Name</label>
                <input type="text" name="new_fullname" class="form-control" value="<?php echo $new_fullname; ?>">
                <span class="help-block"><?php echo $new_fullname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_student_id_err)) ? 'has-error' : ''; ?>">
                <label>New Student ID</label>
                <input type="text" name="new_student_id" class="form-control" value="<?php echo $new_student_id; ?>">
                <span class="help-block"><?php echo $new_student_id_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="dashboard.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
