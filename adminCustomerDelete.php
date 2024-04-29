<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect to login page
    header("Location: admin_login.php");
    exit;
}

// Get customer ID
$id = $_GET["id"];

// Delete customer
$conn->query("DELETE FROM tblUser WHERE id = $id");

// Redirect to customer management page
header("Location: admin_customers.php");
exit;