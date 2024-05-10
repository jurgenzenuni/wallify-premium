<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: home.php");
    exit;
}

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

if (isset($_GET['username'])) {
    $requestedUsername = $_GET['username'];

    // Query to retrieve portfolio images for the requested user along with image ID
    $sql = "SELECT p.image_id, f.file_name
            FROM portfolio p
            INNER JOIN free_img f ON p.image_id = f.id
            WHERE p.username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $requestedUsername);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // If username parameter is not provided, use the logged-in user's username
    $requestedUsername = $username;

    $sql = "SELECT p.image_id, f.file_name
            FROM portfolio p
            INNER JOIN free_img f ON p.image_id = f.id
            WHERE p.username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $requestedUsername);
    $stmt->execute();
    $result = $stmt->get_result();
}

if (isset($requestedUsername)) {
    // Fetch the profile picture path for the requested username
    $fetchPfpQuery = "SELECT pfp FROM wallify_users WHERE username = ?";
    $stmtPfp = $conn->prepare($fetchPfpQuery);
    $stmtPfp->bind_param("s", $requestedUsername);
    $stmtPfp->execute();
    $resultPfp = $stmtPfp->get_result();

    // Check if a result was found
    if ($resultPfp->num_rows > 0) {
        $row = $resultPfp->fetch_assoc();
        // Check if pfp value is null
        if ($row["pfp"] !== null) {
            // Encode the profile picture data as base64
            $profilePicturePath = 'data:image/jpeg;base64,' . base64_encode($row["pfp"]);
        } else {
            // Set the picture path to an image in the images folder
            $profilePicturePath = 'images/dpfp.png';
        }
    } else {
        // Set the picture path to an image in the images folder
        $profilePicturePath = 'images/dpfp.png';
    }
}


// Handle image removal
if (isset($_POST['remove_image'])) {
    $imageIdToRemove = $_POST['image_id_to_remove'];
    // Delete the image from the portfolio
    $deleteSql = "DELETE FROM portfolio WHERE image_id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $imageIdToRemove);
    $deleteStmt->execute();

    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}


// Query the database to check if the user is premium
$query = "SELECT premium FROM wallify_users WHERE username = '$username'";
$result2 = mysqli_query($conn, $query);

$isPremium = 0; // Default value
if ($result2 && mysqli_num_rows($result2) > 0) {
    $row = mysqli_fetch_assoc($result2);
    $isPremium = $row['premium'] == 1 ? 1 : 0; // Set $isPremium to 1 if true, 0 if false
    mysqli_free_result($result2);
} else {
    echo "<p>Error: Unable to retrieve premium status.</p>";
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Carter+One&family=Oleo+Script+Swash+Caps&family=Pacifico&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=MuseoModerno:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "Ubuntu", sans-serif;
            font-weight: 400;
        }

        .usertitle {
            font-weight: 600;
            font-size: 40px;
            font-family: Arial, Helvetica, sans-serif;
            margin-left: 20px;
            color: white;
            margin-bottom: 10px;
        }

        .portfolio {
            font-weight: 600;
            font-size: 25px;
            font-family: Arial, Helvetica, sans-serif;
            margin-left: 10px;
        }

        .img-container {
            /* display: flex;
        flex-wrap: wrap;
        
        justify-content: center; */
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .img-container img {
            /* object-fit: cover;
        width: 600px;
        height: auto; 
        margin: 10px; */
            margin: 10px;
            width: 600px;
            height: 100%;
            object-fit: cover;
        }


        .bodyclass {
            display: flex;
            justify-content: center;
        }

        @media (min-width: 300px) {
            .grid {
                columns: 1;
                gap: 12px;
            }

            .grid img {
                max-width: 100%;
                padding-top: 12px !important;
            }
        }

        @media (min-width: 600px) {
            .grid {
                columns: 2;
                gap: 12px;
            }

            .grid img {
                max-width: 100%;
                padding-top: 12px !important;
            }
        }

        @media (min-width:900px) {
            .grid {
                columns: 3;
                gap: 20px;
            }

            .grid img {
                padding-top: 20px !important;
            }
        }

        .grid {
            justify-content: center;
            max-width: 1800px;
        }

        .grid img {
            width: 600px;
        }

        /* NAVBAR */
        @media (max-width: 1000px) {
            .dropdown {
                margin-right: 60px !important;
            }
        }

        @media (max-width: 1000px) {
            .login-button {
                margin-right: 70px !important;
            }
        }

        .navbar {
            padding: 1px;
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
            background-color: white;
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
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><line x1="3" y1="6" x2="27" y2="6" stroke="black" stroke-width="2"/><line x1="3" y1="14" x2="27" y2="14" stroke="black" stroke-width="2"/><line x1="3" y1="22" x2="27" y2="22" stroke="black" stroke-width="2"/></svg>');
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
            font-family: 'Pacifico', cursive;
            ;
            font-size: 25px;
            position: absolute;
            left: calc(80px + 5px);
            /* Adjust the value to align with the logo */
            top: 17px;
            /* Adjust the value to vertically align with the logo */
        }

        .nav-link {
            /* color: #666777; */
            color: rgba(54, 54, 54, 0.63);
            font-weight: 500;
            position: relative;
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

        .upload-section {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .upload-form {
            max-width: 800px;
        }

        /* @media screen and (max-width: 450px) {
    .upload-form{
        width: 50px;
    }
} */

        /* ===================================== Profile section ================================== */
        /* img {
  max-width: 100%; } */
        .container {
            max-width: 1800px;
        }

        /* @media screen and (max-width: 1060px) {
    .container {
      max-width: 100%;
      overflow: hidden; } }

@media screen and (max-width: 1060px) {
  .overcover {
    padding: 10px; } } */

        /* .top-cover {
  background-image: url(./images/blackhbg2.jpg);
  background-size: cover;
  height: 500px;
  width: 100%; }

.overcover {
  padding: 0px;}

@media screen and (min-width: 767px) {
    .no-margin {
        margin-left: 80px;
        }
    }
  .overcover .covwe-inn {
    background-color: rgba(0, 0, 0, 0.4);
    width: 100%;
    height: 100%;
    padding: 14px;
    display: flex; }
    @media screen and (max-width: 450px) {
      .overcover .covwe-inn {
        padding: 10px; } 
    }
    .overcover .covwe-inn .img-c {
      padding: 20px;
      justify-content: center;
      display: flex;}
      .overcover .covwe-inn .img-c img {
        border-radius: 50%;
        object-fit: cover;
        background-color: whitesmoke;
        padding: 3px;
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        margin: auto; }
    .overcover .covwe-inn .tit-det {
      padding: 20px;
      padding-left: 10px;
      margin: auto; }
      .overcover .covwe-inn .tit-det h2 {
        color: white;
        font-size: 2.8rem; }
        @media screen and (max-width: 450px) {
          .overcover .covwe-inn .tit-det h2 {
            font-size: 1.8rem; } }
      .overcover .covwe-inn .tit-det p {
        color: #FFF;
        font-size: 1rem;
        text-indent: 20px; }
    @media screen and (max-width: 767px) {
      .overcover .covwe-inn {
        text-align: center; } }
    @media screen and (max-width: 450px) {
        .overcover .covwe-inn .img-c {
         margin-bottom: -40px; }
        }
    @media screen and (max-width: 450px) {
        .overcover .covwe-inn .img-c img {
         height: 250px; }
        } */

        /* .profile-box {
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  padding: 0px; } */

        @media (min-width: 991px) {
            .nav.nav-tabs .nav-link::before {
                content: "";
                position: absolute;
                bottom: 0;
                left: 0%;
                transform: translateX(-50%);
                width: 0;
                height: 0px;
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

        .navbar {
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            /* Adjust shadow properties as needed */
        }

        .image-container {
            position: relative;
            /* Make the container relative for absolute positioning of the button */
            display: inline-block;
            /* Ensure inline-block display for proper button positioning */
        }

        .download-button {
            display: none;
            /* Initially hide the download button */
            position: absolute;
            /* Position the button absolutely */
            bottom: 5px;
            /* Adjust button position as needed */
            left: 5px;
            /* Adjust button position as needed */
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            text-decoration: none;
            z-index: 2;
        }

        .image-container:hover .download-button {
            transition: 0.5s ease-in-out;
            display: block;
            /* Display the download button when hovering over the image container */
        }

        .download-button:hover {
            background-color: rgba(0, 0, 0, 0.7);
            transition: 0.3s ease-in-out;
        }

        .rmv-btn {
            display: none;
            /* Initially hide the download button */
            position: absolute;
            /* Position the button absolutely */
            bottom: 5px;
            /* Adjust button position as needed */
            left: 100px;
            /* Adjust button position as needed */
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            text-decoration: none;
            z-index: 2;
        }

        .image-container:hover .rmv-btn {
            transition: 0.5s ease-in-out;
            display: block;
            /* Display the download button when hovering over the image container */
        }

        .rmv-btn:hover {
            background-color: rgba(0, 0, 0, 0.7);
            transition: 0.3s ease-in-out;
        }

        .footer-color {
            background-color: #131313;
        }

        .footer-color a {
            color: white;
            /* Set text color to white */
            text-decoration: none;
            /* Remove underline */
        }

        .overcover {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .covwe-inn {
            /* background: linear-gradient(to right, rgba(246, 246, 246, 0), #f6f6f6, rgba(246, 246, 246, 0)); */
        }

        .pfp img {
            height: 200px;
            width: 200px;
            object-fit: cover;
            border-radius: 50%;
            display: block;
            margin: 0 auto;
        }

        .username {
            font-size: 60px;
            font-family: "MuseoModerno", sans-serif;
        }

        @media only screen and (max-width: 600px) {
            .username {
                font-size: 45px;
                /* Adjust the font size for smaller screens */
            }
        }

        .pfp {
            position: relative;
            display: inline-block;
            border-radius: 50%;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
            margin-top: 40px;
        }

        .pfp img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
        }

        .edit-button {
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.3);
            /* Adjust background color and opacity */
            color: white;
            font-weight: bold;
            opacity: 0;
            /* Initially hide the edit button */
            transition: opacity 0.3s ease;
            /* Add transition effect */
        }

        .edit-button img {
            border-radius: 0 !important;
        }

        .pfp:hover .edit-button {
            opacity: 1;
            /* Show the edit button when hovering over the profile picture container */
            cursor: pointer;
        }

        .btn-upload {
            background-color: #000000;
            color: white;
            border-radius: 4px;
            padding: 10px;
            text-decoration: none;
            border: none;
            justify-content: center;
        }

        .btn-upload:hover {
            background-color: #55bcc9;
            transition: 0.5s ease-in-out;
            color: white;
        }

        .nav-tabs .nav-link.active {
            border-radius: 40px;
            background-color: #131313;
            /* Set your desired background color */
            color: white;
            /* Set text color */
            margin-bottom: 5px;
            text-align: center;
            /* Center the text horizontally */
            padding: 15px;
            /* Remove default padding */
        }

        .nav-tabs .nav-link:hover {
            border-radius: 40px;
            background-color: #131313;
            /* Set your desired background color */
            color: white;
            /* Set text color */
            text-align: center;
            /* Center the text horizontally */
            padding: 15px;
            /* Remove default padding */
            transition: 0.5S ease-in-out;
        }

        .nav-tabs .nav-link {
            border-radius: 40px;
            background-color: white;
            /* Set your desired background color */
            color: black;
            /* Set text color */
            margin-bottom: 5px;
            text-align: center;
            /* Center the text horizontally */
            padding: 15px;
            /* Remove default padding */
            margin-right: 5px;
        }

        .rev-form {
            display: inline-block;
            text-align: center;
            width: 650px;
            /* Optional: Set max width for the form */
            margin: 0 auto;
            /* Center the form horizontally */
            margin-bottom: 10px;
        }

        .toggle-form {
            padding: 9px;
            cursor: pointer;
            background-color: #131313;
            color: white;
            border-radius: 25px;
            max-width: 350px;
            justify-content: center;
            cursor: pointer;
            margin: 0 auto;
            /* Center the toggle-form horizontally */
            width: fit-content;
            /* Ensure the width fits its content */
            margin-bottom: 10px;
        }

        .cslbutton {
            background-color: #000000;
            font-size: 16px;
            color: rgb(255, 255, 255);
            border-radius: 4px;
            padding: 12px;
            text-decoration: none;
            border: none;
            outline: none;
            font-weight: 600;
            box-shadow: 0 0 6px rgba(255, 255, 255, 0.1);
            margin-top: 10px;
        }

        .cslbutton:hover {
            font-weight: 600;
            background-color: #55bcc9;
            transition: 0.3s;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
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
            <div class="collapse navbar-collapse justify-content-center" style="margin-right: 100px;"
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
                        <a class="nav-link mx-lg-2" href="gallery.php">Gallery</a>
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
                        <li><a class="dropdown-item active" href="userprof.php?username=<?php echo $username; ?>"> View
                                Profile </a></li>
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

    <div class="container-fluid overcover">
        <div class="container profile-box">
            <div class="top-cover">
                <div class="covwe-inn">
                    <div class="pfp">
                        <!-- <img src="images/default-profile-image2.png" alt=""> -->
                        <img src="<?php echo $profilePicturePath; ?>" alt="">
                        <?php if ($loggedIn && ($username === $requestedUsername)): ?>
                            <div class="edit-button" data-bs-toggle="modal" data-bs-target="#editProfilePictureModal">
                                <img src="images/camera2.png" style="width: 50px; height: 50px;">
                            </div>
                        <?php endif; ?>
                    </div> <br>
                    <div class="username">
                        <?php
                        if (isset($requestedUsername)) {
                            echo $requestedUsername;
                        } else {
                            echo $username;
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Picture Modal -->
            <div class="modal fade" id="editProfilePictureModal" tabindex="-1"
                aria-labelledby="editProfilePictureModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProfilePictureModalLabel">Edit Profile Picture</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../backend/upload_profile_picture.php" method="post"
                                enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="newProfilePicture" class="form-label">Select new profile
                                        picture:</label>
                                    <input type="file" class="form-control" id="newProfilePicture"
                                        name="newProfilePicture">
                                </div>
                                <button type="submit" class="btn btn-upload">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <ul class="nav nav-tabs custom-nav-tabs" id="myTab" role="tablist"
                style="margin-left:5px; margin-top:10px;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link tab-item active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                        type="button" role="tab" aria-controls="home" aria-selected="true">Portfolio</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link tab-item" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">Upload</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link tab-item" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                        type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="bodyclass">
                        <div class="grid">
                            <?php
                            // Display portfolio images
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<div class='image-container'>";
                                    echo "<img src='uploads/images/{$row['file_name']}' alt=''>";
                                    // Generate unique filename based on timestamp
                                    $timestamp = time(); // Get current timestamp
                                    $filename = "image_" . $timestamp . ".png"; // Example filename format
                                    echo "<a href='uploads/images/{$row['file_name']}' download='$filename' class='download-button'>Download</a>";
                                    // Add remove button
                                    echo "<form method='post'>";
                                    if ($username === $requestedUsername) {
                                        // Only show remove button if logged-in user is the owner of the page
                                        echo "<input type='hidden' name='image_id_to_remove' value='{$row['image_id']}'>";
                                        echo "<button type='submit' name='remove_image' class='rmv-btn'>Remove</button>";
                                    }
                                    echo "</form>";
                                    echo "</div>";
                                }
                            } else {
                                echo "No images found in portfolio.";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <?php if ($username === $requestedUsername): ?>
                        <div class="upload-section" style="margin-left: 0px;">
                            <form class="upload-form" action="../backend/upload.php" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" name="username" value="<?php echo $username; ?>">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="image" name="image" style="width: 100%;">
                                </div>
                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags (comma-separated)</label>
                                    <input type="text" class="form-control" id="tags" name="tags" style="width: 100%;">
                                </div>
                                <?php if ($isPremium): ?>
                                    <div class="mb-3">
                                        <label for="premium" class="form-label">Premium</label>
                                        <select class="form-control" id="premium" name="premium">
                                            <option value="1">Premium</option>
                                            <option value="0">Free</option>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <button type="submit" class="btn-upload" style="margin-bottom: 15px;">Upload</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="upload-section" style="margin-left: 0px;">
                            <p>You are not authorized to upload images on this page.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab"
                style="margin-top: 10px;">
                <div class="container">

                    <h3 class="toggle-form">Submit a Review ▼</h3>
                    <div class="rev-form" style="display: none;"> <!-- Initially hide the form -->
                        <?php
                        if ($requestedUsername == $username) {
                            // If the requested and username are the same, display an error message
                            echo "<p>You cannot review yourself.</p>";
                        } else {
                            // If the requested and username are not the same, display the review form
                            ?>
                            <form action="../backend/submit_review.php" method="post">
                                <!-- <div class="form-group">
                                    <label for="reviewer"></label>
                                    <input type="text" class="form-control" id="reviewer" name="reviewer"
                                        placeholder="Your Username" required>
                                </div> -->
                                <input type="hidden" name="reviewer"
                                    value="<?php echo htmlspecialchars($username); ?>">
                                <!-- Hidden input for reviewer -->
                                <input type="hidden" name="reviewed"
                                    value="<?php echo htmlspecialchars($requestedUsername); ?>">
                                <!-- Hidden input for reviewed username -->
                                <div class="form-group">
                                    <label for="score"></label>
                                    <input type="number" class="form-control" id="score" name="score" min="1" max="10"
                                        placeholder="Score (1-10)" required>
                                </div>
                                <div class="form-group">
                                    <label for="review_text"></label>
                                    <textarea class="form-control" id="review_text" name="review_text" rows="3"
                                        placeholder="Review Description" required></textarea>
                                </div>
                                <button type="submit" class="cslbutton">Submit Review</button>
                            </form>
                            <?php
                        }
                        ?>
                    </div>

                    <?php
                    $servername = "localhost";
                    $usernamedb = "user1";
                    $password = "Password618";
                    $dbname = "wallify";

                    $conn = new mysqli($servername, $usernamedb, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch reviews where the reviewed user matches $username
                    $reviewedUsername = ($username === $requestedUsername) ? $username : $requestedUsername;
                    $reviewsQuery = "SELECT reviewer, score, review_text FROM reviews WHERE reviewed = ?";
                    $stmt = $conn->prepare($reviewsQuery);
                    $stmt->bind_param("s", $reviewedUsername);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if there are any reviews
                    if ($result->num_rows > 0) {
                        // Output each review
                        while ($row = $result->fetch_assoc()) {
                            $reviewer = $row['reviewer'];
                            $score = $row['score'];
                            $reviewText = $row['review_text'];
                            ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Reviewer: <?php echo $reviewer; ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Score: <?php echo $score; ?></h6>
                                    <p class="card-text"><?php echo $reviewText; ?></p>
                                    <?php
                                        // Check if the reviewer is the current user
                                        if ($reviewer === $username) {
                                            ?>
                                            <form action="../backend/delete_review.php" method="post">
                                                <input type="hidden" name="reviewer" value="<?php echo $reviewer; ?>">
                                                <input type="hidden" name="reviewed" value="<?php echo $requestedUsername; ?>">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // No reviews found
                        echo "<p>No reviews found.</p>";
                    }

                    // Free the result set
                    $stmt->close();

                    // Close database connection
                    $conn->close();
                    ?>
                </div>
            </div>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var toggleForm = document.querySelector('.toggle-form');
                    var reviewForm = document.querySelector('.rev-form');

                    toggleForm.addEventListener('click', function () {
                        if (reviewForm.style.display === 'none') {
                            reviewForm.style.display = 'block'; // Show the form if it's hidden
                        } else {
                            reviewForm.style.display = 'none'; // Hide the form if it's visible
                        }
                    });
                });
            </script>
</body>

</html>