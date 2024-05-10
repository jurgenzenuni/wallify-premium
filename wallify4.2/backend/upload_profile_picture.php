<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: home.php");
    exit;
}

if (isset($_FILES["newProfilePicture"]) && $_FILES["newProfilePicture"]["error"] === UPLOAD_ERR_OK) {
    
    $servername = "localhost";
    $usernamedb = "user1";
    $password = "Password618";
    $dbname = "wallify";
    $conn = new mysqli($servername, $usernamedb, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get username
    $username = $_SESSION["username"];

    $stmt = $conn->prepare("UPDATE wallify_users SET pfp = ? WHERE username = ?");
    $stmt->bind_param("ss", $newProfilePicture, $username);

    // Read uploaded file data
    $newProfilePicture = file_get_contents($_FILES["newProfilePicture"]["tmp_name"]);

    // Execute the update query
    if ($stmt->execute()) {
        echo "<div style='text-align:center;'><div style='display:inline-block; padding:10px; background-color:#4CAF50; color:white;'>Profile picture updated successfully.</div></div>";
    } else {
        echo "<div style='text-align:center;'><div style='display:inline-block; padding:10px; background-color:#f44336; color:white;'>Error updating profile picture: " . $conn->error . "</div></div>";
    }

    $conn->close();
} else {
    echo "<div style='text-align:center;'><div style='display:inline-block; padding:10px; background-color:#f44336; color:white;'>No file uploaded or upload error occurred.</div></div>";
}

?>

<script>
    setTimeout(function () {
        window.history.back();
    }, 1);
</script>


