<?php
session_start();

// Logout
session_destroy();

// Redirect to login page
header("Location: admin_login.php");
exit;
?>