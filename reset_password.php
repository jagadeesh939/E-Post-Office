<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password='$new_password' WHERE username='$username'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Password updated successfully! <a href='login.php'>Login Here</a>";
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
    <title>Reset Password | E-Post Office</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="reset-container">
        <h2>Reset Password</h2>
        <form action="reset_password.php" method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="new_password" placeholder="Enter New Password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>

<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password='$new_password' WHERE username='$username'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Password updated successfully! <a href='login.php'>Login Here</a>";
    } else {
        echo "Error updating password: " . $conn->error;
    }
}
?>

