<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect to login page
    header("Location: admin_login.php");
    exit;
}

// Get customer data
$id = $_GET["id"];
$result = $conn->query("SELECT * FROM tblUser WHERE id = $id");
$customer_data = $result->fetch_assoc();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $verified = isset($_POST["verified"]) ? 1 : 0;

    // Update customer
    $conn->query("UPDATE tblUser SET username = '$username', email = '$email', verified = $verified WHERE id = $id");

    // Redirect to customer management page
    header("Location: admin_customers.php");
    exit;
}

// Display form
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo $customer_data["username"];?>" required><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $customer_data["email"];?>" required><br><br>
    <label for="verified">Verified:</label>
    <input type="checkbox" id="verified" name="verified" value="1" <?php if ($customer_data["verified"] == 1) { echo "checked"; } ?>>
    <br><br>
    <input type="submit" value="Save">
</form>

<br>
<a href="admin_customers.php">Back to customer management</a>