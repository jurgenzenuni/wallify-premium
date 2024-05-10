<?php
session_start();

// Check if user is logged in
if (isset($_SESSION["username"])) {
    $loggedIn = true;
    $username = $_SESSION["username"];
} else {
    $loggedIn = false;
}

// Handle login logic
if (isset($_POST["login"])) {
    // Redirect to login page
    header("Location: login2.php");
    exit;
}

include 'config.php';
$image = '';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['generate'])) {
        $prompt = $_POST['prompt'];

        if (!empty($prompt)) {
            $prompt = trim($prompt);
            $genObj->prompt = $prompt;

            $image = $genObj->generate();
        } else {
            $error = "Fields are Required";
        }
    }
}

$servername = "localhost";
$usernamedb = "user1";
$password = "Password618";
$database = "wallify";

$conn = new mysqli($servername, $usernamedb, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle form submission
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['submit'])) {
        // Get filename and prompt from form
        $filename = basename($_POST['filename']);
        $desc2 = $_POST['prompt_value'];
        // file_put_contents('description_log.txt', "Description: " . $description . PHP_EOL, FILE_APPEND);

        // Create description by adding ', AI, AI generated' to the prompt
        $description = $desc2 . ", AI, AI generated";

        // Insert into database
        $sql = "INSERT INTO free_img (file_name, description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        // Check if the SQL query was prepared successfully
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("ss", $filename, $description);

            // Execute the statement
            $stmt->execute();

            // Close statement
            $stmt->close();

            // Redirect or do further processing
            header("Location: frontend/gallery.php?search=ai+generated");
            exit;
        } else {
            // If an error occurred while preparing the statement
            echo "Error: " . $conn->error;
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Image Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Boostrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet"> 
    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="frontend/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="frontend/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="frontend/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="frontend/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="frontend/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=Oleo+Script+Swash+Caps&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <style>
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
    .dropdown-item:focus, .dropdown-item:active {
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
    .navbar-toggler:focus, .btn-close:focus {
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
    width: 100px;
    }
    .wallify-brand {
        color: black;
        font-family: 'Pacifico', cursive;;
        font-size: 25px;
        position: absolute;
        left: calc(80px + 5px); /* Adjust the value to align with the logo */
        top: 17px; /* Adjust the value to vertically align with the logo */
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
    .nav-link:hover, .nav-link.active {
        /* color: #000; */
        color: black;
    }
    /* Make active page white in navbar */
    .navbar .navbar-nav .nav-link.active {
        color: black; /* Your desired color for the active nav link */
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
    .nav-link:hover::before, .nav-link.active::before {
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
    body {
        font-family: "Ubuntu", sans-serif;
        /* font-weight: 400; */
        /* background-image: url("./frontend/images/aboutbg1.jpg"); */
        background-color: #f2f2f2;
    }
		.upload-btn {
			background-color: black;
			color: white;
			border-radius: 1px;
			padding: 6px;
			opacity: 0.4; 
  			transition: opacity 0.2s ease-in-out;
			margin-top: 4px;
		}
		.upload-btn:hover {
			/* background-color: black;
			color: white; */
			opacity: 0.8;
			box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5); /* Add the desired shadow properties */
		}
		.upload-btn {
			display: none; /* Hide the button by default */
		}
		.image-container:hover .upload-btn {
			display: block; /* Show the button on hover */
		}
        .div55 {
            background-color: #e5e5e5;
            border-radius: 15px;
            max-width: 1000px;
            padding: 180px;
            border: 1px solid #d8d8d8; /* Add border */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: absolute;
            margin-top: 20px;
            overflow-y: auto; 
        }
        .navbar {
            box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.1); 
        }
        .footer-color{
            background-color:#131313 ;
        }
        .footer-color a {
        color: white; /* Set text color to white */
        text-decoration: none; /* Remove underline */
        }
        #loader img {
            height: 100px;
            margin-left: 35px;
            justify-content: center;
            display: flex;
        }
        .reco-head {
            text-align: center;
        }
        .search-ai {
            width: 600px;
        }
        .ai-btn {
            margin-top: -20px;
            background-color: black;
        }
        .ai-btn:hover {
            background-color: #55bcc9;
            transition: 0.5s ease-in-out;
        }
        ul li button {
        display: block;
        padding: 10px 20px;
        margin-bottom: 10px;
        border: none;
        border-radius: 20px;
        background-color: #d8d8d8;
        color: black;
        transition: background-color 0.3s ease;
        }

        ul li button:hover {
            background-color: black;
            color: white;
            transition: ease-in-out 0.5s;
        }
        /* .navbar .navbar-nav .nav-link.active {
             color: white;
        } */
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
        @media only screen and (max-width: 768px) {
        .search-ai {
            max-width: 280px; /* Set max-width to your desired size */
        }
        }
	</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-dark">
    <div class="container-fluid">
    <a href="./frontend/home.php" class="logomargins">
         <img src="./frontend/images/wlogo4.png" alt="Logo" class="logo">
          </a>
        <a class="navbar-brand wallify-brand" href="#">Wallify</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" style="margin-right: 93px;" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link mx-lg-2" aria-current="page" href="./frontend/home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="./frontend/aboutpg.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-lg-2 active" href="../imageai.php">Image Generation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="./frontend/gallery.php">Gallery</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="./frontend/search.html">Portfolio</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="./frontend/contact.php">Contact</a>
                </li>
            </ul>
        </div>
        <?php if ($loggedIn) : ?>
          <div class="dropdown d-inline-block user-button" style="margin-right: 10px; position: absolute; top: 22px; right: 10px;">
              <button class="btn dropdown-toggle dropdown-toggle-split" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="./frontend/images/default-profile-image2.png" class="profile-image" style="width: 20px; height: 20px;">
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <li><span class="dropdown-item-text">Welcome, <?php echo $username; ?></span></li>
                  <li><a class="dropdown-item" href="frontend/userprof.php?username=<?php echo $username; ?>"> View Profile </a></li>
                  <li><a class="dropdown-item" href="backend/logout.php">Logout</a></li>
              </ul>
          </div>
        <?php else : ?>
            <a href="./frontend/login2.php" class="login-button" style="margin-right: 10px; position: absolute; top: 22px; right: 10px;">Login</a>
        <?php endif; ?>
            </div>
  </nav>
<!-- End Navbar -->


<div class="container mt-5">
  <div class="row">
    <div class="col-lg-6 offset-lg-3">
      <h2 class="mb-4 reco-head">Recommendations for Prompts to increase quality</h2>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Here are some suggestions for your prompts to Enhance your AI-generated content!</h5>
          <h5 class="card-title" style="font-weight: bold;">Click to add: </h5>
          <ul style="font-weight: bold;">
            <li><button onclick="addTextToInput(this)">Focus on realistic lighting and shadows for lifelike appearances.</button></li>
            <li><button onclick="addTextToInput(this)">Emphasize fine lines and precise shapes for crisp visuals.</button></li>
            <li><button onclick="addTextToInput(this)">Prioritize realistic rendering of materials such as fabric, metal, or glass.</button></li>
            <li><button onclick="addTextToInput(this)">Create images with intricate textures and fine details.</button></li>
          </ul>
          <p class="card-text">By incorporating these recommendations, you can improve the quality and relevance of the AI-generated output.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<form id="form" method="POST" enctype="multipart/form-data">
    <div class="wrapper flex flex-1 " class="div55">
        <div class="inner-wrapper flex flex-1 w-full h-screen">
            <!--CONTENT_WRAPPER-->
            <div class="flex flex-1 h-full items-start justify-center">
                <!--INNER_CONTENT_WRAPPER-->
                <div class="flex flex-1 w-full flex-col items-center justify-center div55">
                    <!--LOGO_SECTION-->
                    <div class="w-full flex flex-1 items-center justify-center flex-col">
                        <!--LOGO_IMAGE_DIV-->
                        <div class="w-96 overflow-hidden items-center sm:mt-0 md:mt-20 sm:mt-20 mb-6 flex justify-center flex-col text-center relative">
                            <div id="loader" class="hidden w-40 h-40 overflow-hidden">
                                <img src="frontend/images/loading5.gif">
                            </div>
                            <!-- Check if Image is generated -->
                            <?php if (!empty($image)):?>
								<div class="image-container">
									<img src="<?php echo $image;?>" id="generated-image" />
                                    <button class="upload-btn absolute bottom-1 left-1" type="button" onclick="copyImageLink('http://3.91.149.75/wallify4.1/<?php echo $image;?>')">Copy Link</button>
									<!-- <button class="upload-btn absolute bottom-1 right-25" id="upload-btn">Upload</button> -->
                                    <a href="<?php echo $image;?>" download="generated_image.png" class="upload-btn absolute bottom-1 right-1" id="upload-btn">Download</a>
                                    
									<span class="text-gray-800 text-sm"></span>
                                    <form id="form2" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="filename" value="<?php echo $image; ?>"> 
                                        <input type="hidden" name="prompt_value" id="promptValue" value="<?php echo isset($_POST['prompt']) ? $_POST['prompt'] : ''; ?>">
                                        <button type="submit" name="submit" class="upload-btn absolute bottom-1 right-24">Share</button> 
                                    </form>
								</div>
                            <?php else:?>
                                <!-- else display the logo image -->
                                <!-- <img id="logo" src="frontend/images/"/> -->
                                <p> Generate an AI Image </p>
                                <!-- Error here -->
                                <span class="text-red-800 text-sm font-bold">
                                    <?php 
                                    if(isset($error)){
                                        echo $error;
                                    }
                                    ?>
                                </span>
                            <?php endif;?>
                        </div>
                        <!--LOGO_IMAGE_DIV_ENDS-->
                        <!--INPUT_SECTION-->
                        <div class="">
                            <label class="relative">
                                <span class="absolute flex left-4 text-gray-300" style="top:22px;"><i class="fas fa-search"></i></span>
                                <input class="pl-9 py-3 pr-3 border w-full text-gray-800 search-ai text-center" type="text" name="prompt" id="promptInput" placeholder="Generate images by AI" />
                            </label>
                        </div>
                    </div>
                    <div>
                        <div class="pt-5 flex items-center justify-center flex-col">
                            <div>
                                <button class="bg-blue-500 px-3 py-3 rounded text-white hover:shadow-md ai-btn" name="generate">Generate Image</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</form>
<!-- <script>
    function updatePromptValue(value) {
        document.getElementById('promptValue').value = value;
    }
</script> -->
<script>
    function copyImageLink(imageUrl) {
        var imageLink = document.createElement('input');
        imageLink.setAttribute('value', imageUrl);
        document.body.appendChild(imageLink);
        imageLink.select();
        document.execCommand('copy');
        document.body.removeChild(imageLink);
        alert('Image link copied to clipboard!');
    }
</script>
<script>

    $("#form").submit(function(){
        $("#logo").hide();
        $("#loader").removeClass('hidden');
    })
	
</script>    
<script>
    // JavaScript function to add text to the input field
    function addTextToInput(button) {
        // Get the text content of the clicked button
        var buttonText = button.textContent;
        // Get the existing value of the input field
        var inputText = document.getElementById('promptInput').value;
        // Concatenate the new text with the existing text, adding a space in between
        var newText = inputText + ' ' + buttonText;
        // Set the value of the input field to the concatenated text
        document.getElementById('promptInput').value = newText;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

<!--FOOTER-->
<footer class="footer-color">
        <div class="container">
            <div class="row justify-content-center text-center text-light">
                <div class="col-md-3 mt-4 footimg">
                    
                    <p style="margin-top: 60px">Official Wallify Website</p>
                </div>
                <div class="col-md-3 mt-5">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Gallery</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mt-5">
                    <h5>Contact Us</h5>
                    <p>123 Main Street<br> City, State ZIP<br> Country</p>
                    <p>Email: info@example.com<br> Phone: +1234567890</p>
                </div>
                <div class="col-md-3 mt-5">
                    <h5>Connect With Us</h5>
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="row justify-content-center text-center text-light mt-5">
                <div class="col-md-12">
                    <hr class="bg-light">
                    <p>&copy; 2024 Wallify. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

</html>
