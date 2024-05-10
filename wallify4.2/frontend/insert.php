<!-- <?php
$servername = "localhost";
$username = "user1";
$password = "Password618";
$dbname = "wallify";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$imageDirectory = 'uploads/images';

$jsonFile = 'pexels-prompts-pairs.json';
$jsonData = file_get_contents($jsonFile);
$descriptions = json_decode($jsonData, true);

$files = scandir($imageDirectory);
foreach ($files as $file) {
    if (!in_array($file, array(".", ".."))) {
        if (pathinfo($file, PATHINFO_EXTENSION) == 'jpg' || pathinfo($file, PATHINFO_EXTENSION) == 'png') {
            $imageId = pathinfo($file, PATHINFO_FILENAME);

            $description = "No description available";
            foreach ($descriptions as $item) {
                if (isset($item[$imageId])) {
                    $description = $item[$imageId];
                    break;
                }
            }

            $description = mysqli_real_escape_string($conn, $description); 
            $sql = "INSERT INTO free_img (file_name, description) VALUES ('$file', '$description')";
            if ($conn->query($sql) === TRUE) {
                echo "Record inserted successfully for $file<br>";
            } else {
                echo "Error inserting record: " . $conn->error;
            }
        }
    }
}

$conn->close();
?> -->

