<?php
include 'db_connect.php'; // Connect to the database
session_start();
$user_id = $_SESSION["user_id"]; // Get logged-in user ID

$message = "Your payment was successful!";
$sql = "INSERT INTO notifications (user_id, message) VALUES ($user_id, '$message')";
mysqli_query($conn, $sql);

echo "Payment Successful! Notification added.";
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];
    $amount = $_POST['amount'];

    // Validate card details
    if (!preg_match("/^\d{16}$/", $card_number)) {
        $message = "❌ Card number must be 16 digits!";
    } elseif (!preg_match("/^\d{3}$/", $cvv)) {
        $message = "❌ CVV must be 3 digits!";
    } elseif (!preg_match("/^(0[1-9]|1[0-2])\/\d{2}$/", $expiry)) {
        $message = "❌ Expiry must be in MM/YY format!";
    } elseif ($amount <= 0) {
        $message = "❌ Amount must be greater than $0!";
    } else {
        // Insert into database
        $sql = "INSERT INTO payments (user_id, name, card_number, expiry, cvv, amount) 
                VALUES (1, '$name', '$card_number', '$expiry', '$cvv', '$amount')";
        if (mysqli_query($conn, $sql)) {
            $message = "✅ Payment of $$amount is successful! Thank you.";
        } else {
            $message = "❌ Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Make Payment</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a0dad, #9b30ff);
            color: white;
            text-align: center;
        }
        form {
            background: white;
            color: black;
            padding: 20px;
            width: 300px;
            margin: auto;
            border-radius: 10px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #6a0dad;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            margin-top: 10px;
            cursor: pointer;
        }
        button:hover {
            background: #9b30ff;
        }
    </style>
</head>
<body>
    <h2>💳 Make Payment</h2>
    <form method="POST">
        <label>👤 Cardholder Name:</label>
        <input type="text" name="name" required>

        <label>💳 Card Number (16 digits):</label>
        <input type="text" name="card_number" pattern="\d{16}" title="Enter a 16-digit card number" required>

        <label>📅 Expiry Date (MM/YY):</label>
        <input type="text" name="expiry" pattern="(0[1-9]|1[0-2])/\d{2}" title="Enter expiry in MM/YY format" required>

        <label>🔑 CVV (3 digits):</label>
        <input type="text" name="cvv" pattern="\d{3}" title="Enter a 3-digit CVV" required>

        <label>💰 Amount ($):</label>
        <input type="number" name="amount" min="1" required>

        <button type="submit">Pay Now</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>
