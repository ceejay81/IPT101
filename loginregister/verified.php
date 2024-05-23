<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Successful</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .success-message {
            margin-top: 20vh;
            font-size: 24px;
            text-align: center;
            color: green;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="success-message">
        <?php echo "Your email has been successfully verified!"; ?>
    </div>
    <div class="mt-3 text-center">
        <p>Proceed to <a href="login.php">Login</a></p>
    </div>
</div>
</body>
</html>
