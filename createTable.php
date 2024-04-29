<?php
include 'DBConn.php';

// Check if table exists
$result = $conn->query("SHOW TABLES LIKE 'tblUser'");

if ($result->num_rows > 0) {
    // Table exists, delete it
    $conn->query("DROP TABLE tblUser");
}

// Create table
$conn->query("CREATE TABLE tblUser (
    id INT AUTO_INCREMENT,
    name VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(100),
    PRIMARY KEY (id)
)");

// Load data from userData.txt
$data = file('userData.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($data as $line) {
    list($name, $email, $password) = explode(';', $line);
    $conn->query("INSERT INTO tblUser (name, email, password) VALUES ('$name', '$email', '$password')");
}

$conn->close();
?>