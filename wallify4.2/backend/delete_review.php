<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $reviewer = $_POST['reviewer'];
    $reviewedUsername = $_POST['reviewed'];

    $servername = "localhost";
    $usernamedb = "user1";
    $password = "Password618";
    $dbname = "wallify";

    $conn = new mysqli($servername, $usernamedb, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $deleteQuery = "DELETE FROM reviews WHERE reviewer = ? AND reviewed = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("ss", $reviewer, $reviewedUsername);

    if ($stmt->execute() === TRUE) {
        // Redirect 
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit(); 
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    
    echo "Invalid request.";
}
?>
