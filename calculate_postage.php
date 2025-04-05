<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $weight = $_POST["weight"];
    $type = $_POST["shipping_type"];
    
    // Define postage rates (you can modify these values)
    $rate_per_kg = [
        "standard" => 5.00,  // Standard Shipping: $5 per kg
        "express" => 10.00,  // Express Shipping: $10 per kg
        "overnight" => 20.00 // Overnight Shipping: $20 per kg
    ];

    if (isset($rate_per_kg[$type])) {
        $cost = $weight * $rate_per_kg[$type];
        $message = "Your total postage cost is <strong>$$cost</strong>";
    } else {
        $message = "Invalid shipping type selected!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculate Postage</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a0dad, #9b30ff);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            color: black;
        }
        h2 {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        select, input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            background: #6a0dad;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        button:hover {
            background: #9b30ff;
        }
        .result {
            margin-top: 15px;
            font-size: 18px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📦 Calculate Postage</h2>
        <form method="post">
            <label for="weight">Enter Parcel Weight (kg):</label>
            <input type="number" name="weight" id="weight" required step="0.1">

            <label for="shipping_type">Select Shipping Type:</label>
            <select name="shipping_type" id="shipping_type">
                <option value="standard">Standard Shipping</option>
                <option value="express">Express Shipping</option>
                <option value="overnight">Overnight Shipping</option>
            </select>

            <button type="submit">Calculate</button>
        </form>

        <?php if (isset($message)): ?>
            <div class="result"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
