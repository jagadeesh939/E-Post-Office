<?php
session_start();
include 'db_connect.php';

if (isset($_GET["id"])) {
    $pickup_id = $_GET["id"];
    $user_id = $_SESSION["user_id"];

    $sql = "DELETE FROM pickups WHERE id = '$pickup_id' AND user_id = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Pickup request cancelled!'); window.location.href='view_pickups.php';</script>";
    } else {
        echo "<script>alert('Error cancelling pickup'); window.location.href='view_pickups.php';</script>";
    }
}
?>
