<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $secretKey = RECAPTCHA_SECRET;

    // Check if g-recaptcha-response is set
    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        die("reCAPTCHA verification failed. Please try again.");
    }

    $captcha = $_POST['g-recaptcha-response'];

    // Verify the reCAPTCHA response
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
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

        // Check if username already exists
        $checkStmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            // Redirect existing users to login.php
            header("Location: login.php");
            exit();
        } else {
            // Insert new user into database
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);

            if ($stmt->execute()) {
                // Redirect successful sign-ups to dashboard.php
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $checkStmt->close();
        $conn->close();
    } else {
        echo "reCAPTCHA verification failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="container">
        <form action="signup.php" method="POST" class="signup-form">
            <h2>Create an Account</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6LdkyHMqAAAAAFf5gKnu02HiXfu_tIwUnv5jc25q"></div>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
    </div>
</body>
</html>
