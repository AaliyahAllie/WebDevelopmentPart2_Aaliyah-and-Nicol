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
        // Check if user already exists
        $result = $conn->query("SELECT * FROM tblUser WHERE email = '$email' OR username = '$username'");

        if ($result->num_rows > 0) {
            $errors[] = "User already exists";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $conn->query("INSERT INTO tblUser (username, email, password, verified) VALUES ('$username', '$email', '$hashed_password', 0)");

            echo "User registered successfully. Please wait for administrator verification.";
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
    <input type="submit" value="Register">
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