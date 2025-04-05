<?php
session_start();
include 'db_connect.php';

$sql = "SELECT * FROM pickups ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pickup Requests</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #6a0dad, #9b30ff); color: white; text-align: center; }
        table { width: 80%; margin: 20px auto; background: white; color: black; border-radius: 10px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; }
        th { background: #6a0dad; color: white; }
        select { padding: 5px; }
        button { background: #6a0dad; color: white; padding: 5px 10px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>📦 All Pickup Requests</h2>
    <table>
        <tr>
            <th>Pickup ID</th>
            <th>User ID</th>
            <th>Address</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Update</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row["id"]; ?></td>
            <td><?= $row["user_id"]; ?></td>
            <td><?= $row["address"]; ?></td>
            <td><?= $row["date"]; ?></td>
            <td><?= $row["time"]; ?></td>
            <td>
                <form method="POST" action="update_pickup.php">
                    <input type="hidden" name="pickup_id" value="<?= $row["id"]; ?>">
                    <select name="status">
                        <option value="Pending" <?= $row["status"] == "Pending" ? "selected" : ""; ?>>Pending</option>
                        <option value="Completed" <?= $row["status"] == "Completed" ? "selected" : ""; ?>>Completed</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
