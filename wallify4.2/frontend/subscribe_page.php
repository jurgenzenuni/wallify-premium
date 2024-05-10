<?php
// Start session
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe to Wallify+</title>
      <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link href="./css/style.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=Oleo+Script+Swash+Caps&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=MuseoModerno:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .container {
            max-width: 600px;
            margin: auto;
            margin-top: 20px;
        }
        .card {
            margin-top: 20px;
            box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.1); 
        }
        .card-text {
            font-size: 18px;
            font-weight: bold;
        }
        .card-text-p {
            font-size: 24px;
            font-weight: bold;
        }
        .btn-sub {
            display: flex;
            background-color: #000000;
            color: white;
            border-radius: 4px;
            padding: 10px;
            text-decoration: none;
            border: none;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .btn-sub:hover {
            background-color: #55bcc9;
            transition: 0.5s ease-in-out;
            color: white;
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
        background-color: white;
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
    /*footer color*/
    .footer-color{
        margin-top: 320px;
    background-color:#131313 ;
    }
    .footer-color a {
    color: white; /* Set text color to white */
    text-decoration: none; /* Remove underline */
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" style="margin-right: 63px;" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link mx-lg-2" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="about.php">About</a>
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
        <?php if ($loggedIn) : ?>
          <div class="dropdown d-inline-block user-button" style="margin-right: 10px; position: absolute; top: 22px; right: 10px;">
              <button class="btn dropdown-toggle dropdown-toggle-split" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="./images/default-profile-image2.png" class="profile-image" style="width: 20px; height: 20px;">
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <li><span class="dropdown-item-text">Welcome, <?php echo $username; ?></span></li>
                  <li><a class="dropdown-item" href="userprof.php?username=<?php echo $username; ?>"> View Profile </a></li>
                  <li><a class="dropdown-item" href="../backend/logout.php">Logout</a></li>
              </ul>
          </div>
        <?php else : ?>
            <a href="login2.php" class="login-button" style="margin-right: 10px; position: absolute; top: 22px; right: 10px;">Login</a>
        <?php endif; ?>
            </div>
  </nav>
<!-- End Navbar -->

    <div class="container">
        <h1 class="text-center">Subscribe to Wallify+</h1>
        <div class="card">
            <div class="card-body">
                <!-- <h5 class="card-title">Wallify+ Subscription</h5> -->
                <p class="card-text">Unlock premium features and access exclusive content with Wallify+ subscription.
                </p>
                <ul>
                    <li>Access to premium wallpapers</li>
                    <li>Enjoy the exclusive feature of sharing premium wallpapers</li>
                    <li>Priority customer support</li>
                </ul>
                <p class="card-text-p">Price: $3.99/month</p>
                <form action="process_subscription.php" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="card_number" class="form-label">Credit Card Number</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="expiry_date" class="form-label">Expiry Date</label>
                        <input type="text" class="form-control" id="expiry_date" name="expiry_date"
                            placeholder="MM/YYYY" required>
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" required>
                    </div>
                    <button type="submit" class="btn btn-sub">Subscribe Now</button>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

      <!--FOOTER-->
      <footer class="footer-color">
        <div class="container">
            <div class="row justify-content-center text-center text-light">
                <div class="col-md-3 mt-4">
                    <img src="images/wlogo4.png" alt="Wallify Logo" height="120px">
                    <p style="margin-top: -18px">Official Wallify Website</p>
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