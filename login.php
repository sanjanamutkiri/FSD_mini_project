<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $secretKey = '6LdkyHMqAAAAAFelfAMbjqSwyKkpYG_1sq3gArIO'; // Replace with your reCAPTCHA secret key
    $captcha = $_POST['g-recaptcha-response'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
    $responseKeys = json_decode($response, true);

    if ($responseKeys["success"]) {
        // Database connection
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare user input
        $username = htmlspecialchars(trim($_POST['username']));
        $password = trim($_POST['password']);

        // Check credentials
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                echo "<script>alert('Login successful!'); window.location.href='dashboard.php';</script>";
            } else {
                echo "<script>alert('Invalid password. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Username does not exist. Please sign up.'); window.location.href='signup.php';</script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<script>alert('reCAPTCHA verification failed. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="login.php">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <div class="g-recaptcha" data-sitekey="6LdkyHMqAAAAAFf5gKnu02HiXfu_tIwUnv5jc25q"></div><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
