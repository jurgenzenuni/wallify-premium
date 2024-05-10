<?php
session_start();

if (isset($_SESSION["username"])) {
    $loggedIn = true;
    $username = $_SESSION["username"];
} else {
    $loggedIn = false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"]) && isset($_POST["tags"])) {
    
    $servername = "localhost";
    $usernamedb = "user1";
    $password = "Password618";
    $dbname = "wallify";

    $uploadDirectory = "../frontend/uploads/images/";

    $conn = new mysqli($servername, $usernamedb, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $imageFile = $_FILES["image"];
    $imageName = $imageFile["name"];
    $imageTmpName = $imageFile["tmp_name"];

    // Move uploaded image to destination directory
    $destination = $uploadDirectory . $imageName;
    if (move_uploaded_file($imageTmpName, $destination)) {
        // Get tags from form input
        $tags = $_POST["tags"];
        $tagArray = explode(",", $tags);
        $description = implode(", ", $tagArray);

        // Update JSON file with image description
        $jsonFile = '../frontend/pexels-prompts-pairs.json';
        $jsonData = file_get_contents($jsonFile);
        $descriptions = json_decode($jsonData, true);
        $descriptions[pathinfo($imageName, PATHINFO_FILENAME)] = $description;
        $jsonData = json_encode($descriptions, JSON_PRETTY_PRINT);
        file_put_contents($jsonFile, $jsonData);

        $imgPremium = isset($_POST['premium']) && $_POST['premium'] == 1 ? 1 : 0;

        // Insert image data into the database with associated username
        $sql = "INSERT INTO free_img (file_name, description, user, premium) VALUES ('$imageName', '$description', '$username', '$imgPremium')";
        if ($conn->query($sql) === TRUE) {
            // Success message
            echo "<div style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 7px; background-color: #fff ; border: none; padding: 40px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);'>
                    <h2>Image uploaded successfully!</h2>
                    <p> Returning to your profile shortly.. </p>
                  </div>";
            echo "<script>
                    setTimeout(function () {
                        window.location.href = '../frontend/userprof.php';
                    }, 1500); // 3000 milliseconds = 3 seconds
                  </script>";
        } else {
            // Error message
            echo "<div style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 7px; background-color: #f2dede; border: 1px solid #a94442; padding: 10px;'>
                    <h2>Error: " . $sql . "<br>" . $conn->error . "</h2>
                    <p> Returning to your profile shortly.. </p>
                  </div>";
            echo "<script>
                    setTimeout(function () {
                        window.location.href = '../frontend/userprof.php';
                    }, 1500); // 3000 milliseconds = 3 seconds
                  </script>";
        }
    } else {
        // Error message
        echo "<div style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 7px; background-color: #f2dede; border: 1px solid #a94442; padding: 10px;'>
                <h2>Error uploading image!</h2>
                <p> Returning to your profile shortly.. </p>
              </div>";
        echo "<script>
                setTimeout(function () {
                    window.location.href = '../frontend/userprof.php';
                }, 1500); // 3000 milliseconds = 3 seconds
              </script>";
    }

    $conn->close();
}

?>


