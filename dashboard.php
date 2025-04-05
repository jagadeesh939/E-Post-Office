<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E Post Office | Dashboard</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #6a0dad, #9b30ff); /* Purple gradient with wave effect */
            background-size: cover;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            position: absolute;
            top: 20px;
        }
        .header h1 {
            font-size: 36px;
            background: white;
            color: #6a0dad;
            padding: 15px 30px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .header img {
            width: 50px;
            height: 50px;
        }
        .welcome {
            margin-top: 80px; /* Moved below header */
            font-size: 20px;
        }
        .options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px; /* Increased gap for better spacing */
            margin-top: 50px; /* Adjusted to avoid clutter */
        }
        .option {
            width: 150px;
            height: 150px;
            background: white;
            color: black;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
            position: relative;
        }
        .option img {
            width: 60px;
            height: 60px;
            position: absolute;
            top: -30px;
            border-radius: 50%;
            object-fit: cover;
        }
        .option i {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .option:hover {
            background: #6a0dad;
            color: white;
            transform: scale(1.1);
        }
        .option span {
            display: block;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><img src="logo.png" alt="Logo"> E Post Office</h1>
    </div>
    <?php
    // Check if user session is set, otherwise redirect to login
    session_start();
    if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
        header("Location: login.php"); // Redirect to login page if no user
        exit();
    }
    ?>
    <div class="welcome">Welcome, <strong><?php echo htmlspecialchars($_SESSION["user"]); ?></strong>!</div>
    <div class="options">
        <a href="track_parcel.php" class="option">
            <img src="track_logo.png" alt="Track Logo">
            <i class="fas fa-box"></i>
            <span>Track Parcel</span>
        </a>
        <a href="schedule_pickup.php" class="option">
            <img src="schedule_logo.png" alt="Schedule Logo">
            <i class="fas fa-calendar-alt"></i>
            <span>Schedule Pickup</span>
        </a>
        <a href="calculate_postage.php" class="option">
            <img src="postage_logo.png" alt="Postage Logo">
            <i class="fas fa-dollar-sign"></i>
            <span>Calculate Postage</span>
        </a>
        <a href="make_payment.php" class="option">
            <img src="payment_logo.png" alt="Payment Logo">
            <i class="fas fa-credit-card"></i>
            <span>Make Payment</span>
        </a>
        <a href="notifications.php" class="option">
            <img src="notification_logo.png" alt="Notification Logo">
            <i class="fas fa-bell"></i>
            <span>Notifications</span>
        </a>
        <a href="contact.php" class="option">
            <img src="contact_logo.png" alt="Contact Logo">
            <i class="fas fa-phone"></i>
            <span>Contact Support</span>
        </a>
    </div>
</body>
</html>