<?php
include 'DBConn.php';

// Initialize variables
$username = $email = $password = $hashed_password = '';
$errors = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "Please fill in all fields";
    } else {
        // Check if user exists
        $result = $conn->query("SELECT * FROM tblUser WHERE email = '$email' AND username = '$username'");

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $hashed_password = $user_data["password"];

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Login successful
                session_start();
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                $_SESSION["logged_in"] = true;

                echo "User $username is logged in";
                echo "<br>";
                echo "User data: ";
                echo "<br>";
                echo "<table>";
                echo "<tr><th>Column Name</th><th>Value</th></tr>";
                foreach ($user_data as $column => $value) {
                    echo "<tr><td>$column</td><td>$value</td></tr>";
                }
                echo "</table>";
            } else {
                $errors[] = "Invalid password";
            }
        } else {
            $errors[] = "User not found";
        }
    }
}

// Display form
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo $username;?>" required><br><br>
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

<?php
if (!isset($_SESSION["logged_in"])) {
    echo "<p>Not registered? <a href='register.php'>Register now</a></p>";
}
?>