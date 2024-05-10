<?php
session_start();

$servername = "localhost";
$username = "user1";
$password = "Password618";
$dbname = "wallify";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        
        $username = $conn->real_escape_string($_POST["username"]);
        $password = $conn->real_escape_string($_POST["password"]);

        $sql = "SELECT * FROM wallify_users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User found, verify password
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {

                $_SESSION["username"] = $username;
                // Redirect to home.html
                header("Location: ../frontend/home.php");
                exit;
            } else {
                // Password does not match, set error message
                $error_message = "Wrong password";
            }
        } else {
            // User not found, set error message
            $error_message = "Username not found";
        }
    }
}

$conn->close();

if(isset($error_message)) {
    header("Location: ../frontend/login2.php?error_message=".urlencode($error_message));
    exit;
}
?>

