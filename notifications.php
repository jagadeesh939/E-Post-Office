<?php
include 'db_connect.php'; // Database Connection
session_start();
$user_id = $_SESSION["user_id"];

$sql = "SELECT message, created_at FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Notifications | E-Post Office</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a0dad, #9b30ff);
            color: white;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: auto;
            background: white;
            color: black;
            padding: 20px;
            border-radius: 10px;
        }
        .notification {
            background: #f4f4f4;
            padding: 10px;
            border-left: 5px solid #6a0dad;
            margin-bottom: 10px;
        }
        .date {
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>🔔 Notifications</h2>
    <div class="container">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="notification">
                    <p><?php echo $row['message']; ?></p>
                    <p class="date"><?php echo date('d M Y, h:i A', strtotime($row['created_at'])); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No new notifications.</p>
        <?php endif; ?>
    </div>
</body>
</html>
