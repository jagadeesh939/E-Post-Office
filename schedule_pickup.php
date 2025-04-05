<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];
    $pickup_date = $_POST['pickup_date'];

    $query = "INSERT INTO pickups (user_id, address, pickup_date, status) VALUES ('$user_id', '$address', '$pickup_date', 'Pending')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['success_message'] = "✅ Pickup Scheduled Successfully!";
    } else {
        $_SESSION['error_message'] = "❌ Failed to Schedule Pickup: " . mysqli_error($conn);
    }

    // Redirect to view pickups page
    header("Location: view_pickups.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Pickup</title>
    <style>
        body { background: linear-gradient(135deg, #6a0dad, #9b30ff); font-family: Arial, sans-serif; }
        .container { width: 40%; margin: auto; background: white; padding: 20px; border-radius: 10px; }
        input, button { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #6a0dad; color: white; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📦 Schedule Pickup</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <textarea name="address" placeholder="Pickup Address" required></textarea>
            <input type="date" name="date" required>
            <input type="time" name="time" required>
            <button type="submit">Schedule Pickup</button>
        </form>
    </div>
</body>
</html>
