<?php
$servername = "localhost";
$username = "root";
$password = ""; // Leave empty if no password
$database = "epostoffice"; // Use correct database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
