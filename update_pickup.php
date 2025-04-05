<?php
include 'db_connect.php';
session_start();
$user_id = $_SESSION["user_id"]; // Get logged-in user ID

$parcel_id = $_POST["parcel_id"];
$status = $_POST["status"]; // Example: "Dispatched" or "Delivered"

$message = "Your parcel #$parcel_id status changed to $status.";
$sql = "INSERT INTO notifications (user_id, message) VALUES ($user_id, '$message')";
mysqli_query($conn, $sql);

echo "Parcel status updated. Notification sent.";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pickup_id = $_POST["pickup_id"];
    $status = $_POST["status"];

    $sql = "UPDATE pickups SET status='$status' WHERE id='$pickup_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Pickup status updated!'); window.location.href='admin_pickups.php';</script>";
    } else {
        echo "<script>alert('Error updating status'); window.location.href='admin_pickups.php';</script>";
    }
}
?>
