<?php
include 'db_connect.php'; // Ensure this file is properly included

session_start();
$user_id = $_SESSION['user_id'] ?? 0;

// Fetch scheduled pickups for the logged-in user
$query = "SELECT * FROM pickups WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Pickups</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a0dad, #9b30ff);
            color: white;
            text-align: center;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            color: black;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #6a0dad;
            color: white;
        }
        tr:nth-child(even) {
            background: #f4f4f4;
        }
        .btn {
            text-decoration: none;
            background: #6a0dad;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 15px;
        }
        .btn:hover {
            background: #9b30ff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📅 Scheduled Pickups</h2>
    <table>
        <tr>
            <th>Pickup ID</th>
            <th>Address</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['pickup_date']}</td>
                        <td>{$row['status']}</td>
                        <td><a href='cancel_pickup.php?id={$row['id']}' class='btn'>Cancel</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No scheduled pickups found.</td></tr>";
        }
        ?>
    </table>

    <a href="dashboard.php" class="btn">⬅ Back to Dashboard</a>
</div>

</body>
</html>
