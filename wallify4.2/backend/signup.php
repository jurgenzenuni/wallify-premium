<?php

$servername = "localhost";
$username = "user1";
$password = "Password618";
$dbname = "wallify";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST['signupPassword'], PASSWORD_DEFAULT); // Hash the password for security

    // Check if username already exists
    $check_username_query = "SELECT * FROM wallify_users WHERE username='$username'";
    $result = $conn->query($check_username_query);
    if ($result->num_rows > 0) {
        // Username already exists, send error response to client
        http_response_code(400);
        echo "Username already exists. Please choose a different username.";
        exit();
    } else {
        // Insert user information into the users table
        $sql = "INSERT INTO wallify_users (firstname, lastname, username, email, password) VALUES ('$firstname', '$lastname', '$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: signup-success.html");
            exit();
        } else {
            http_response_code(500);
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit();
        }
    }
}

$conn->close();
?>
