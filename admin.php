<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect to login page
    header("Location: admin_login.php");
    exit;
}

// Admin user is logged in, display admin dashboard
echo "Admin dashboard";

// Display customer management options
echo "<br>";
echo "<a href='admin_customers.php'>Manage customers</a>";

// Display logout button
echo "<br>";
echo "<form action='logout.php' method='post'>";
echo "<input type='submit' value='Logout'>";
echo "</form>";
?>