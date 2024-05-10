<?php
session_start();

if (isset($_SESSION["username"])) {
    $loggedIn = true;
    $username = $_SESSION["username"];
} else {
    $loggedIn = false;
}

if (isset($_POST["login"])) {
    header("Location: login2.php");
    exit;
}

$servername = "localhost";
$usernamedb = "user1";
$password = "Password618";
$dbname = "wallify";

$conn = new mysqli($servername, $usernamedb, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchQuery = isset($_GET['search']) ? $_GET['search'] : 'free wallpapers';
$sql = "SELECT * FROM free_img WHERE description LIKE '%$searchQuery%'";
$result = $conn->query($sql);

if (!empty($searchQuery)) {
    $searchQuery = $conn->real_escape_string($searchQuery);
    $searchLogsSql = "INSERT INTO search_logs (search_term) VALUES ('$searchQuery') ON DUPLICATE KEY UPDATE search_count = search_count + 1";
    $conn->query($searchLogsSql);
}

// Display images
$limit = 200; // Limit to 200
$count = 0;

// Query the database to check if the user is premium
$isPremium = 0;

if ($loggedIn) {
    $query = "SELECT premium FROM wallify_users WHERE username = '$username'";
    $result2 = mysqli_query($conn, $query);

    if ($result2 && mysqli_num_rows($result2) > 0) {
        $row = mysqli_fetch_assoc($result2);
        $isPremium = $row['premium'] == 1 ? 1 : 0; // Set $isPremium to 1 if true, 0 if false
        mysqli_free_result($result2);
    } else {
        echo "<p>Error: Unable to retrieve premium status.</p>";
    }
} else {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Carter+One&family=Oleo+Script+Swash+Caps&family=Pacifico&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=MuseoModerno:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "Ubuntu", sans-serif;
            font-weight: 400;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
        }

        .image {
            margin: 10px;
        }

        .image img {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }

        .image p {
            display: none;
            /* Hide description */
        }

        /* NAVBAR */
        @media (max-width: 1000px) {
            .dropdown {
                margin-right: 60px !important;
            }
        }

        @media (max-width: 1000px) {
            .login-button {
                margin-right: 60px !important;
            }
        }

        .navbar {
            padding: 1px;
            box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 920px) {
            .navbar {
                margin-top: 3px !important;
            }
        }

        .login-button {
            /* background-color: #009970; */
            background-color: black;
            /* color: #fff; */
            color: white;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: 0.3s background-color;
        }

        .login-button:hover {
            /* background-color: #00b383; */
            background-color: #55bcc9;
        }

        .user-button {
            /* background-color: #009970; */
            background-color: whitesmoke;
            /* color: #fff; */
            /* color: black; */
            font-size: 14px;
            padding: 1px 3px;
            border-radius: 10px;
            text-decoration: none;
            transition: 0.3s background-color;
        }

        .user-button:hover {
            /* background-color: #00b383; */
            background-color: #55bcc9;
            transition: background-color 0.3s ease;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .dropdown-menu .dropdown-item:hover {
            color: black;
            font-weight: 600;
        }

        .dropdown-item:focus,
        .dropdown-item:active {
            background-color: #55bcc9;
        }

        .btn {
            border: none;
        }

        .btn:focus {
            box-shadow: none;
            outline: none;
        }

        .dropdown-toggle-split::after {
            display: none !important;
        }

        .navbar-toggler {
            border: none;
            font-size: 1.25rem;
        }

        .navbar-toggler:focus,
        .btn-close:focus {
            box-shadow: none;
            outline: none;
        }

        /* Hamburger white */
        .navbar-toggler-icon {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><line x1="3" y1="6" x2="27" y2="6" stroke="black" stroke-width="3"/><line x1="3" y1="14" x2="27" y2="14" stroke="black" stroke-width="3"/><line x1="3" y1="22" x2="27" y2="22" stroke="black" stroke-width="3"/></svg>');
            margin-right: -5px;
        }

        .logo {
            height: 100px;
            width: 100px;
            margin-right: -18px;
            margin-top: -10px;
        }

        .logomargins {
            margin-left: -10px;
            height: 80px;
            width: 80px;
        }

        .wallify-brand {
            color: black;
            font-family: 'Pacifico', cursive;
            ;
            font-size: 25px;
            position: absolute;
            left: calc(80px + 5px);
            /* Adjust the value to align with the logo */
            top: 17px;
            /* Adjust the value to vertically align with the logo */
        }

        .wallify-brand:hover {
            color: #55bcc9;
        }

        .nav-link {
            /* color: #666777; */
            /* color: rgba(255, 255, 255, 0.63); */
            color: rgba(54, 54, 54, 0.63);
            font-weight: 500;
            position: relative;
            margin-top: -2px;
        }

        .nav-link:hover,
        .nav-link.active {
            /* color: #000; */
            color: black;
        }

        /* Make active page white in navbar */
        .navbar .navbar-nav .nav-link.active {
            color: black;
            /* Your desired color for the active nav link */
        }

        @media (min-width: 991px) {
            .nav-link::before {
                content: "";
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 0;
                height: 2.5px;
                /* background-color: #009970; */
                background-color: black;
                visibility: hidden;
                transition: 0.3s ease-in-out;
            }

            .nav-link:hover::before,
            .nav-link.active::before {
                width: 100%;
                visibility: visible;
            }
        }

        @media (max-width: 720px) {
            .logomargins {
                margin-left: -30px;
            }
        }

        @media (max-width: 720px) {
            .navbar-brand {
                margin-left: -22px;
            }
        }

        @media (max-width: 920px) {
            .navbar-collapse {
                margin-right: 0px !important;
            }
        }

        .navbar-collapse {
            text-align: center;
            /* margin-right: 0px !important; */
        }

        .gallerytop {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .gallerytle {
            margin-top: 7px;
            display: flex;
            justify-content: center;
        }

        .gallery {
            display: flex;
            justify-content: center;
        }

        .save-button {
            display: none;
            position: absolute;
            bottom: 5px;
            right: 5px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            z-index: 2;
        }

        .save-button:hover {
            background-color: rgba(0, 0, 0, 0.7);
            transition: 0.3s ease-in-out;
        }

        .download-button {
            display: none;
            position: absolute;
            bottom: 5px;
            right: 58px;
            /* Adjusted left position */
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            text-decoration: none;
            z-index: 2;
        }

        .download-button:hover {
            background-color: rgba(0, 0, 0, 0.7);
            transition: 0.3s ease-in-out;
        }

        .image-container:hover .download-button {
            display: block;
        }

        .image-container:hover .save-button {
            display: block;
        }

        .image-container {
            max-width: 1800px;
            position: relative;
            display: inline-block;
            margin: 3px;
            overlay: hidden;
        }

        .image-container img {
            width: 600px;
        }

        .image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-shadow: inset 0 0 20px 10px rgba(0, 0, 0, 0.3);
            z-index: 1;
            /* transition: opacity 0.3s ease;  */
            opacity: 0;
        }


        .image-container:hover::before {
            opacity: 1;
        }

        .image-username {
            margin-left: 5px;
            position: absolute;
            bottom: 5px;
            /* Adjust as needed */
            left: 5px;
            /* Adjust as needed */
            font-size: 24px;
            /* font-family: "Ubuntu", sans-serif; */
            font-family: "MuseoModerno", sans-serif;
            color: white;
            padding: 5px;
            cursor: pointer;
            display: none;
            /* Initially hide the username */
            z-index: 2;
            text-decoration: none;
            text-shadow: 2px 2px 7px rgba(0, 0, 0, 1);
        }

        .image-container:hover .image-username {
            display: block;
            /* Show the username when hovering over the image */
        }

        .bodyclass {
            display: flex;
            justify-content: center;
        }

        @media (min-width: 300px) {
            .grid {
                columns: 1;
                gap: 3px;
            }

            .grid img {
                max-width: 100%;
                /* padding-top: 12px !important; */
            }
        }

        @media (min-width: 600px) {
            .grid {
                columns: 2;
                gap: 3px;
            }

            .grid img {
                max-width: 100%;
                /* padding-top: 12px !important; */
            }
        }

        @media (min-width:900px) {
            .grid {
                columns: 3;
                gap: 3px;
            }

            /* .grid img {
                padding-top: 20px !important;
                } */
        }

        .grid {
            justify-content: center;
            max-width: 1800px;
        }

        .grid img {
            width: 600px;
        }

        .loading-icon {
            display: block;
            /* text-align: center;
                font-size: 20px;
                margin-top: 20px; */

            height: 100px;
            justify-content: center;
            display: flex;
            align-items: center;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #galleryContainer {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-bar {
            border-radius: 20px;
            background-color: #f0f0f0;
            padding: 10px 15px;
            width: 800px;
            border: #55bcc9;
        }

        .search-term {
            padding: 10px 15px;
            margin-bottom: 20px;
            margin-right: 10px;
            background-color: #f0f0f0;
            border-radius: 15px;
            font-size: 14px;
            outline: none;
            border: none;
            color: black;
        }

        .search-term:hover {
            background-color: black;
            color: white;
            transition: 0.3s ease-in-out;
        }

        .top-search-terms {
            display: flex;
            justify-content: center;
        }

        .top-s {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .btn-s {
            max-width: 75%;
            padding: 10px 15px;
            margin-bottom: 20px;
            margin-right: 10px;
            background-color: black;
            border-radius: 15px;
            font-size: 14px;
            border: none;
            color: white;
        }

        .btn-s:hover {
            background-color: #55bcc9;
            transition: 0.3s ease-in-out;
            color: white;
        }

        @media (max-width: 768px) {
            .search-bar {
                max-width: 75%;
                width: 340px;
            }

            .search-term {
                font-size: 10px;
                width: 60px;
                padding: 4px 6px;
                margin-right: 4px;
            }
        }

        .login-error-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #ff7f7f;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 9999;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            animation: fadeInOut 3s ease;
        }

        .success-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .error-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .download-button img {
            height: 30px;
            width: 30px;
        }

        .save-button img {
            height: 30px;
            width: 30px;
        }

        .premium-label {
            display: none;
            position: absolute;
            top: 5px;
            right: 5px;
            /* Adjusted left position */
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: default;
            border-radius: 3px;
            text-decoration: none;
            z-index: 2;
        }

        .image-container:hover .premium-label {
            display: block;
        }

        .join-wallify-button {
            display: none;
            position: absolute;
            bottom: 5px;
            right: 5px;
            /* Adjusted left position */
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            text-decoration: none;
            z-index: 2;
        }

        .join-wallify-button:hover {
            background-color: rgba(0, 0, 0, 0.7);
            transition: 0.3s ease-in-out;
        }

        .image-container:hover .join-wallify-button {
            display: block;
        }

        .premium-image-wrapper {
            position: relative;
            display: inline-block;
            /* Ensures the wrapper doesn't collapse */
        }

        .premium-image-wrapper img.watermark {
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            /* Prevents the watermark from being clickable */
            z-index: 1;
            /* Ensure the watermark is behind the image */
        }

        @media (max-width: 991px) {
            .navbar-nav .nav-link.active {
                background-color: #000000;
                border-radius: 40px;
                color: white !important;
            }
        }

        @media (max-width: 991px) {
            .navbar-nav .nav-link:hover {
                color: black;
                font-weight: bold;
                transition: 0.3s;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-dark">
        <div class="container-fluid">
            <a href="home.php" class="logomargins">
                <img src="./images/wlogo4.png" alt="Logo" class="logo">
            </a>
            <a class="navbar-brand wallify-brand" href="#">Wallify</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" style="margin-right: 93px;"
                id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 " href="aboutpg.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="../imageai.php">Image Generation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 active" href="gallery.php">Gallery</a>
                    </li>
                    <!-- <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="search.html">Portfolio</a>
                </li> -->
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="contact.php">Contact</a>
                    </li>
                </ul>
            </div>
            <?php if ($loggedIn): ?>
                <div class="dropdown d-inline-block user-button"
                    style="margin-right: 10px; position: absolute; top: 22px; right: 10px;">
                    <button class="btn dropdown-toggle dropdown-toggle-split" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="./images/default-profile-image2.png" class="profile-image"
                            style="width: 20px; height: 20px;">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><span class="dropdown-item-text">Welcome, <?php echo $username; ?></span></li>
                        <li><a class="dropdown-item" href="userprof.php?username=<?php echo $username; ?>"> View Profile
                            </a></li>
                        <li><a class="dropdown-item" href="../backend/logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="login2.php" class="login-button"
                    style="margin-right: 10px; position: absolute; top: 22px; right: 10px;">Login</a>
            <?php endif; ?>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- <div class="gallerytle">
        <h1>Image Gallery</h1>
    </div> -->
    <!-- Display top search terms -->
    <div>
        <h3 class="top-s"> Top Searches </h3>
    </div>
    <div class="top-search-terms">
        <!-- <p>Top Search Terms:</p> -->
        <?php
        // Fetch top 6 search terms from search_logs table
        $topSearchQuery = "SELECT search_term FROM search_logs ORDER BY search_count DESC LIMIT 6";
        $topSearchResult = $conn->query($topSearchQuery);

        // Output each search term as a button
        if ($topSearchResult->num_rows > 0) {
            while ($row = $topSearchResult->fetch_assoc()) {
                echo "<form method='GET' action=''>";
                echo "<button type='submit' name='search' value='$row[search_term]' class='search-term'>$row[search_term]</button>";
                echo "</form>";
            }
        }
        ?>
    </div>

    <!-- Search form -->
    <div class="gallerytop">
        <form method="GET" action="">
            <label for="search"></label>
            <input class="search-bar" type="text" id="search" name="search" placeholder="Enter keywords">
            <button class="btn-s" type="submit">Search</button>
        </form>
    </div>

    <div id="galleryContainer">
        <!-- <div id="loadingIcon" class="loading-icon">Loading...</div> -->
        <img id="loadingIcon" class="loading-icon" src="images/loading5.gif">

        <div class="bodyclass" style="display: none;">
            <div class="grid">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='image-container'>";
                        // echo "<img src='uploads/images/{$row['file_name']}' alt=''>";
                        echo "<a href='http://localhost/wallify4.2/frontend/userprof.php?username=" . urlencode($row['user'] ? $row['user'] : '') . "' class='image-username'>" . ($row['user'] ? $row['user'] : '') . "</a>";
                        // echo "<p>{$row['description']}</p>";
                
                        // Check if the user is not premium and the image is premium
                        if ($isPremium != 1 && $row['premium'] == 1) {
                            echo "<div class='premium-image-wrapper'>";
                            echo "<img src='uploads/images/{$row['file_name']}' alt=''>";
                            echo "<img src='./images/watermark2.png' class='watermark' alt='Watermark'>";
                            echo "</div>";
                        } else {
                            // Display the image without the watermark
                            echo "<img src='uploads/images/{$row['file_name']}' alt=''>";
                        }

                        // Display premium status with custom style class
                        if ($row['premium'] == 1) {
                            echo "<p class='premium-label'>Wallify+</p>";

                            // Check if the user is premium for premium images only
                            if ($isPremium != 1) {
                                // Display the "Join Wallify+" button if the user is not premium
                                echo "<a href='subscribe_page.php'><button class='join-wallify-button' title='Join Wallify+'>Subscribe</button></a>";

                            }
                        }

                        // Check if the image is not premium or the user is premium
                        if ($row['premium'] != 1 || $isPremium == 1) {
                            echo "<a href='uploads/images/{$row['file_name']}' download='image_{$row['id']}.png' class='download-button' title='Download Image'>";
                            echo "<img src='images/download.png' alt='Download'></a>";

                            if (isset($_SESSION['username'])) {
                                echo "<form id='saveForm' method='POST'>";
                                echo "<input type='hidden' name='image_id' value='{$row['id']}'>";
                                echo "<button class='save-button' type='submit' name='save_image' title='Save to Portfolio'>";
                                echo "<img src='images/plus.png' alt='Save'></button>";
                                echo "</form>";
                            } else {
                                echo "<button class='save-button' title='Save to Portfolio' onclick='showLoginError()'>";
                                echo "<img src='images/plus.png' alt='Save'></button>";
                            }
                        }

                        echo "</div>";
                        $count++;
                        if ($count >= $limit)
                            break;
                    }
                } else {
                    $defaultImagesDirectory = 'uploads/nature_images';
                    $defaultImages = scandir($defaultImagesDirectory);
                    foreach ($defaultImages as $image) {
                        if (!in_array($image, array(".", ".."))) {
                            // echo "<div class='image-container'>";
                            echo "<img src='$defaultImagesDirectory/$image' alt=''>";
                            // echo "</div>";
                            $count++;
                            if ($count >= $limit)
                                break;
                        }
                    }
                }

                // Function to save the image
                function saveImage($imageId, $username, $conn)
                {
                    $sql = "INSERT INTO portfolio (image_id, username) VALUES ($imageId, '$username')";

                    if ($conn->query($sql) === TRUE) {
                        return "Image saved successfully";
                    } else {
                        return "Error: Image not saved";
                    }
                }

                // Check if the form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_image'])) {
                    $imageId = $_POST['image_id'];
                    $username = $_SESSION['username'];

                    // Save the image
                    $saveResult = saveImage($imageId, $username, $conn);

                    // Display the result as a popup
                    echo "<script>alert('" . $saveResult . "');</script>";
                }

                $conn->close();
                ?>

                <script>
                    // Disable right-click context menu on images
                    document.addEventListener('contextmenu', function (event) {
                        event.preventDefault();
                    });
                </script>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        document.getElementById("saveForm").addEventListener("submit", function (event) {
                            event.preventDefault(); // Prevent the default form submission

                            var formData = new FormData(this); // Create a FormData object from the form
                            var xhr = new XMLHttpRequest(); // Create a new XMLHttpRequest object

                            // Define what happens on successful data submission
                            xhr.onload = function () {
                                if (xhr.status === 200) {
                                    alert(xhr.responseText); // Display the response from the server
                                } else {
                                    alert('Request failed. Please try again.'); // Display an error message
                                }
                            };

                            // Define what happens in case of an error
                            xhr.onerror = function () {
                                alert('Request failed. Please try again.'); // Display an error message
                            };

                            // Open a connection to the server and send the FormData
                            xhr.open("POST", "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>");
                            xhr.send(formData);
                        });
                    });
                </script>

                <script>
                    setTimeout(function () {
                        document.getElementById('loadingIcon').style.display = 'none';
                        document.querySelector('.bodyclass').style.display = 'block';
                    }, 600);

                    // function showLoginError() {
                    //     alert("You are not logged in.");
                    // }
                    function showLoginError() {
                        // Create a new div element
                        var loginErrorDiv = document.createElement("div");

                        // Set class for styling
                        loginErrorDiv.className = "login-error-message";

                        // Set message content
                        loginErrorDiv.innerHTML = "You are not logged in.";

                        // Append the message to the body
                        document.body.appendChild(loginErrorDiv);

                        // Remove the message after some time (e.g., 3 seconds)
                        setTimeout(function () {
                            document.body.removeChild(loginErrorDiv);
                        }, 3000); // Adjust the delay time (in milliseconds) as needed
                    }
                </script>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>