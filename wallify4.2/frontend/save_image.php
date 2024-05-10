<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['save_image'])) {
    $imageId = $_POST['image_id'];
    $username = $_SESSION['username'];

    $servername = "localhost";
    $usernamedb = "user1";
    $password = "Password618";
    $dbname = "wallify";

    $conn = new mysqli($servername, $usernamedb, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO portfolio (image_id, username) VALUES ($imageId, '$username')";

    if ($conn->query($sql) === TRUE) {
        echo "Image saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
