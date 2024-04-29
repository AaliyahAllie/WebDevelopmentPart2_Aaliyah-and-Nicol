<?php
// Database connection settings
$db_host = 'localhost';
$db_username = 'GroupAN';
$db_password = 'Password12@';
$db_name = 'clothingStore';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}
?>