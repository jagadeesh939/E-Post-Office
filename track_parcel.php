<?php
session_start();
include 'db_connect.php';
// Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tracking_number = $_POST["tracking_number"];
    
    $query = "SELECT * FROM parcels WHERE tracking_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tracking_number);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $parcel = $result->fetch_assoc();
    } else {
        $error = "Tracking number not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Parcel | E Post Office</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6a0dad, #9b30ff);
            text-align: center;
            color: white;
            padding: 50px;
        }
        .container {
            background: white;
            color: black;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
            margin: auto;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        input, button {
            padding: 10px;
            margin: 10px;
            font-size: 18px;
        }
        .status {
            font-size: 22px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>

    <h1>📦 Track Your Parcel</h1>
    <div class="container">
        <form method="POST">
            <input type="text" name="tracking_number" placeholder="Enter Tracking Number" required>
            <br></br>
           

            <button type="back">back</button>
            <button type="submit">Track</button>
        </form>
        
        <?php if (isset($parcel)) { ?>
            <h2>Parcel Details:</h2>
            <p><strong>Sender:</strong> <?php echo $parcel["sender_name"]; ?></p>
            <p><strong>Receiver:</strong> <?php echo $parcel["receiver_name"]; ?></p>
            <p><strong>Destination:</strong> <?php echo $parcel["destination"]; ?></p>
            <p class="status"><strong>Status:</strong> <?php echo $parcel["status"]; ?></p>
        <?php } elseif (isset($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>
    </div>

</body>
</html>
