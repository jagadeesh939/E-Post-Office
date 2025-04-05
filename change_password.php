<?php
include 'db_connect.php';
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION["user"];
    $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password='$new_password' WHERE username='$username'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Password changed successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating password: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Change Password</h2>
        <form action="" method="POST">
            <input type="password" name="new_password" placeholder="New Password" required>
            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>

