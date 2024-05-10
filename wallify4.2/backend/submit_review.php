<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $reviewer = $_POST['reviewer'];
    $reviewedUsername = $_POST['reviewed'];
    $score = $_POST['score'];
    $reviewText = $_POST['review_text'];

    $servername = "localhost";
    $usernamedb = "user1";
    $password = "Password618";
    $dbname = "wallify";

    $conn = new mysqli($servername, $usernamedb, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO reviews (reviewer, reviewed, score, review_text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $reviewer, $reviewedUsername, $score, $reviewText);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        // Redirect back to the same page after successful submission
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // If the form is not submitted, you can handle it here or simply do nothing
    // For example:
    // echo "Form not submitted.";
}
?>


