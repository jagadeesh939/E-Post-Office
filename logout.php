<?php
include 'db_connect.php'; // Connect to the database

session_start();
session_destroy();
header("Location: login.php");
exit();
?>
