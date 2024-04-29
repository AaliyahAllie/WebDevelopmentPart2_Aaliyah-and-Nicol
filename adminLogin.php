<?php
session_start();

// Initialize variables
$email = $password = '';
$errors = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate input
    if (empty($email) || empty($password)) {
        $errors[] = "Please fill in all fields";
    } else {
        // Check if admin user exists
        $result = $conn->query("SELECT * FROM tblUser WHERE email = '$email' AND admin = 1");

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $hashed_password = $user_data["password"];

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Login successful
                session_start();
                $_SESSION["admin_logged_in"] = true;
                $_SESSION["admin_email"] = $email;

                echo "Admin user $email is logged in";
                header("Location: admin.php");
                exit;
            } else {
                $errors[] = "Invalid password";
            }
        } else {
            $errors[] = "Admin user not found";
        }
    }
}

// Display form
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $email;?>" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>

<?php
if (!empty($errors)) {
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
}
?>