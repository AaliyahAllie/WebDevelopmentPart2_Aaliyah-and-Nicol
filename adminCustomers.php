<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect to login page
    header("Location: admin_login.php");
    exit;
}

// Display customers
$result = $conn->query("SELECT * FROM tblUser WHERE admin = 0");

echo "<table>";
echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Verified</th><th>Actions</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["username"] . "</td>";
    echo "<td>" . $row["email"] . "</td>";
    echo "<td>" . ($row["verified"] == 1 ? "Yes" : "No") . "</td>";
    echo "<td>";
    echo "<a href='admin_customer_edit.php?id=" . $row["id"] . "'>Edit</a>";
    echo " ";
    echo "<a href='admin_customer_delete.php?id=" . $row["id"] . "' onclick=\"return confirm('Are you sure you want to delete this customer?')\">Delete</a>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";

// Display logout button
echo "<br>";
echo "<form action='logout.php' method='post'>";
echo "<input type='submit' value='Logout'>";
echo "</form>";