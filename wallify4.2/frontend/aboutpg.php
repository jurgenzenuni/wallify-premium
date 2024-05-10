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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wallify</title>
  <!-- Boostrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- <link href="./css/style.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=Oleo+Script+Swash+Caps&family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=MuseoModerno:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <style>
    body {
      background-image: url("images/aboutbg5.jpg");
      background-size: cover;
      background-position: center;
      margin: 0;
      font-family: sans-serif;
      color: white;
      font-family: "Ubuntu", sans-serif;
      font-weight: 400;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
      padding: 20px;
    }

    .header {
      text-align: center;
      padding-top: 50px;
    }

    .logo {
      font-size: 60px;
      font-weight: bold;
      margin-bottom: 10px;
      font-weight: 500;
      font-family: 'Pacifico', cursive;
      color: white;
    }
    
    .subheading {
      margin-top: -30px;
      font-size: 60px;
      font-weight: 600px;
      text-shadow: 4px 4px 6px rgba(0, 0, 0, 0.9);
      font-family: "MuseoModerno", sans-serif;
      /* font-family: 'Pacifico', cursive; */
    }

    .about {
      font-size: 22px;
      padding: 20px;
      background-color: rgba(0, 0, 0, 0.5);
      margin-top: 50px;
    }

    .about h2 {
      font-size: 36px;
      text-align: center;
      border-bottom: 2px solid white;
    }

    .about p {
      line-height: 1.5;
    }

    .call-to-action {
      text-align: center;
      margin-top: 50px;
      margin-bottom: 30px;
    }

    .call-to-action a {
    background-color: #fff; /* Your original background color */
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    color: #000;            /* Your original text color */
    font-weight: bold;
    transition: background-color 0.3s ease; /* Add a transition */
  }
  .call-to-action a:hover {
    background-color: black; /* Black background on hover */
    color: #fff; 
  }
  .btn-docs {
      text-align: center;
      margin-top: 20px;
      margin-bottom: 15px;
    }

    .btn-docs a {
    background-color: #fff; /* Your original background color */
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    color: #000;            /* Your original text color */
    font-weight: bold;
    transition: background-color 0.3s ease; /* Add a transition */
  }
  .btn-docs a:hover {
    background-color: black; /* Black background on hover */
    color: #fff;
    transition: 0.3s;
  }
    .mission { 
    font-size: 22px;
    padding: 50px 20px;
    background-color: rgba(0, 0, 0, 0.5); 
    margin-top: 50px;
}
    .mission h2 {
    font-size: 36px;
    text-align: center;
    border-bottom: 2px solid white;
}
    .journey { 
    font-size: 22px;
    padding: 50px 20px;
    background-color: rgba(0, 0, 0, 0.5); 
    margin-top: 50px;
}

    .journey h2 {
    font-size: 36px;
    text-align: center;
    border-bottom: 2px solid white;
}
/*footer color*/
.footer-color{
  background-color:#131313 ;
}
.footer-color a {
  color: white; /* Set text color to white */
  text-decoration: none; /* Remove underline */
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
}
@media (max-width: 920px) {
  .navbar {
    margin-top: 3px !important;
  }
}
.login-button {
    /* background-color: #009970; */
    background-color: white;
    /* color: #fff; */
    color: black;
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
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><line x1="3" y1="6" x2="27" y2="6" stroke="white" stroke-width="3"/><line x1="3" y1="14" x2="27" y2="14" stroke="white" stroke-width="3"/><line x1="3" y1="22" x2="27" y2="22" stroke="white" stroke-width="3"/></svg>');
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
   color: whitesmoke;
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
    color: rgba(255, 255, 255, 0.63);
    /* color: rgba(54, 54, 54, 0.63); */
    font-weight: 500;
    position: relative;
    margin-top: -2px;
}
.nav-link:hover, .nav-link.active {
    color: white;
}
.navbar .navbar-nav .nav-link.active {
    color: white;
}
@media (max-width: 991px) {
  .navbar-nav .nav-link.active {
    background-color: #000000;
    border-radius: 40px;
  }
}
@media (max-width: 991px) {
  .navbar-nav .nav-link:hover {
    color: white;
    font-weight: bold;
    transition: 0.3s;
  }
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
        background-color: white;
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
.about .qr-code {
  display: block;
  margin: 0 auto;
  margin-top: 27px;
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
                    <a class="nav-link mx-lg-2 active" href="about.php">About</a>
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
    <header class="header">
      <p class="subheading animate__animated animate__backInDown">Your Canvas, Your World</p>
    </header>
    <section class="about animate__animated animate__fadeIn">
      <h2>Our Story</h2>
      <p>Wallify isn't just another wallpaper app; it's a story of passion, friendship, and a relentless pursuit of visual expression. It all began with Michael and Jurgen, two design enthusiasts frustrated by the lack of inspiring and truly high-quality wallpapers available. They saw a world where phone and desktop screens could be transformed into personal art galleries.</p>
      <div class="btn-docs">
      <a href="mydocs.html">Project Documents</a>
      <br><br>
      <a class="data-btn" href="data.php">Data Analytics</a>
      <img class="qr-code" src="./images/qr-wallify.png">
      <!-- <a href="http://54.160.221.123/mydocuments/">Project Documents</a> -->

      </div>
    </section>
    <section class="mission animate__animated animate__fadeIn">
      <h2>The Mission Begins</h2>
      <p>Driven by the belief that everyone deserves a visually stunning digital experience, Michael and Jurgen set out on a mission. They wanted to create the ultimate wallpaper destination. Wallify was born with these core offerings:</p>
      <ul>
        <li>Discover Stunning Wallpapers: We meticulously handpick high-resolution images from talented photographers and artists around the globe, ensuring every wallpaper is a masterpiece.</li>
        <li>AI-Powered Image Generation: Want something truly unique? Our cutting-edge image generator lets you turn your imagination into stunning wallpapers. Describe your dream visuals and watch them come to life.</li>
        <li>Seamless Portfolio Management: Easily organize your favorite finds, create custom collections, and effortlessly switch between wallpapers to match your mood or style.</li>
      </ul>
    </section>
    <section class="journey animate__animated animate__fadeIn">
      <h2>The Journey Continues, Dreams Soon Realized</h2>
      <p>Wallify's commitment to quality and innovation quickly resonated with users. Word spread, and something magical happened – a community of visual enthusiasts emerged, sharing their creations, and inspiring each other.</p>
      <p>But our dream isn't over yet. We strive to be the world's leading wallpaper app, a place where everyone embraces their digital canvas.</p>
      <p>We invite you to join the Wallify story. Let your screen become your canvas.</p>
    </section>
    <section class="call-to-action">
      <a href="login2.php">Join the Wallify story</a>
    </section>
  </div>

  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> -->
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
