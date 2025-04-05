<?php
session_start();
include 'db_connect.php'; // Database Connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // **Use Prepared Statement to prevent SQL Injection**
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // **Verify password**
        if (password_verify($password, $user['password'])) {
            $_SESSION["user"] = $username;
            $_SESSION["user_id"] = $user['id']; // Store user ID for future use

            header("Location: dashboard.php"); // Redirect to Dashboard
            exit();
        } else {
            echo "<script>alert('❌ Invalid Password!');</script>";
        }
    } else {
        echo "<script>alert('❌ User Not Found!');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Post Office</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
