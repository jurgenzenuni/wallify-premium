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
    <title> Navigation </title>

    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="./css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=Oleo+Script+Swash+Caps&family=Pacifico&display=swap" rel="stylesheet">
    <style>
        .navbar-scrolled {
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Adjust shadow properties as needed */
    }
    </style>
  </head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
         <a href="home.php" class="logomargins">
         <img src="./images/wlogo4.png" alt="Logo" class="logo">
          </a>
          <a class="navbar-brand me-auto" href="#">Wallify</a>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Wallify </h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body text-center">
              <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link mx-lg-2 active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mx-lg-2 " href="aboutpg.php">About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mx-lg-2 " href="../imageai.php">Image Generation</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mx-lg-2 " href="gallery.php">Gallery</a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link mx-lg-2 " href="analytics.html">Portfolio</a>
                </li> -->
                <li class="nav-item">
                  <a class="nav-link mx-lg-2 " href="contact.php">Contact</a>
                </li>
              </ul>
            </div>
          </div>
          <?php if ($loggedIn) : ?>
                <div class="dropdown d-inline-block user-button">
                    <button class="btn dropdown-toggle dropdown-toggle-split" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="./images/default-profile-image2.png" class="profile-image" style="width: 20px; height: 20px;">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><span class="dropdown-item-text">Welcome, <?php echo $username; ?></span></li>
                        <li><a class="dropdown-item" href="userprof.php?username=<?php echo $username; ?>"> View Profile </a> </li>
                        <li><a class="dropdown-item" href="../backend/logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php else : ?>
                <a href="login2.php" class="login-button">Login</a>
            <?php endif; ?>


            <!-- <a href="login2.php" class="login-button">Login</a> -->
            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- carousel Option -->
    <div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" style="height: 45rem;">
            <img src="images/hero-bg2.jpg" class="d-block w-100" alt="Slide 1" style="position: absolute; top: 0; left: 0; min-width: 100%; height: 45rem; object-fit: cover; ">
            <div class="container">
                <div class="carousel-caption text-start" style="bottom: 15rem; z-index: 10;">
                <h1>Explore, Dream, Discover</h1>
                <p>Discover new horizons, dream big, and make unforgettable memories. Become a member today.</p>
                <p><a class="btn btn-lg cslbutton" href="login2.php">Sign up today</a></p>
                </div>
            </div>
            </div>
            <div class="carousel-item" style="height: 45rem;">
            <img src="images/imgbg10.jpg" class="d-block w-100" alt="Slide 2" style="position: absolute; top: 0; left: 0; min-width: 100%; height: 45rem; object-fit: cover;">
            <div class="container">
                <div class="carousel-caption" style="bottom: 15rem; z-index: 10;">
                <h1>Get to Know Us</h1>
                <p>Discover the story behind our journey and the values that drive us forward.</p>
                <p><a class="btn btn-lg cslbutton" href="aboutpg.php">Learn more</a></p>
                </div>
            </div>
            </div>
            <div class="carousel-item" style="height: 45rem;">
            <img src="images/hero-bg1.jpg" class="d-block w-100" alt="Slide 3" style="position: absolute; top: 0; left: 0; min-width: 100%; height: 45rem; object-fit: cover;">
            <div class="container">
                <div class="carousel-caption text-end" style="bottom: 15rem; z-index: 10;">
                <h1> Unlock premium wallpapers with Wallify+ <br> and elevate your device's aesthetic <br> </h1>
                <!-- <p>Shared by creators.</p> -->
                <p><a class="btn btn-lg cslbutton" href="subscribe_page.php">Join Wallify+</a></p>
                </div>
            </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>

    <!-- Other Design Pieces -->

          <!--two cols-->
        <div class="container mt-2">
        <hr class="featurette-divider">
            <div class="row">
            <div class="col-lg-5 mb-4 my-lg-auto">
                    <h1 class="font-weight-bold mb-3"> Explore Our Image Gallery</h1>
                    <p class="mb-4"> Uncover endless possibilities with our vast collection of images and unique artworks tailored to your needs. Search through hundreds of captivating visuals to find the perfect match for your project, inspiration, or personal delight. </p>
                    <a href="gallery.php" class="viewbutton1">View Gallery</a>
            </div>
            <div class="col-lg-7 mb-2"><img src="images/cardimg5.jpg" alt="" class="w-100" style="max-height: 600px; object-fit: cover"></div>
            </div>
            <hr class="featurette-divider">
        </div>

        <!--FIXED BACKGROUND IMAGE-->
        <div class="fixed-background">
            <div class="fixed-wrap">
            <div class="fixed">     
            </div>
            </div>
        </div>

        <div class="container my-2">
        <hr class="featurette-divider">
            <div class="row py-2">
                <div class="col-lg-8">
                    <img src="images/cardimg4.jpg" alt="" class="w-100 ai-img">
                </div>
                <div class="col mb-4 my-lg-auto">
                    <h1 class="font-weight-bold mb-3">OpenAI Image Generation</h1>
                    <p class="mb-4">Using OpenAI DALLE-2 you can generate your own custom images. Users can upload the image to our public database.</p>
                    <a href="../imageai.php" class="viewbutton">Generate Now</a>
                </div>
            </div>
            <hr class="featurette-divider">
        </div>

            <script>
          // JavaScript code to handle photo search functionality
          document.addEventListener('DOMContentLoaded', function () {
              const searchInput = document.getElementById('searchInput');
              const searchButton = document.getElementById('searchButton'); 
              const photoGrid = document.getElementById('photoGrid');
              const loadMoreButton = document.getElementById('loadMoreButton');
              let page = 1;

              async function getPhotos(query, perPage) {
                  const response = await fetch(`https://api.pexels.com/v1/search?query=${query}&per_page=${perPage}`, {
                      headers: {
                          Authorization: '563492ad6f91700001000001eb1029727f5f4b82889fef00ad8f8efd'
                      }
                  });
                  const data = await response.json();
                  return data.photos;
              }

              async function loadPhotos() {
                  const query = searchInput.value || 'Free Wallpaper';
                  const photos = await getPhotos(query, 80);
                  photoGrid.innerHTML = ''; // Clear existing content
                  photos.forEach(function (item) {
                      const img = document.createElement('img');
                      img.src = item.src.original;
                      img.alt = item.id;
                      const div = document.createElement('div');
                      div.className = 'grid-item';
                      div.appendChild(img);
                      photoGrid.appendChild(div);
                  });
              }

              function searchPhotos() {
                  page = 1;
                  loadPhotos();
              }

              loadPhotos();

              searchButton.addEventListener('click', searchPhotos); 

              searchInput.addEventListener('keydown', function (e) { 
                  if (e.keyCode === 13) {
                      searchPhotos();
                  }
              });

              loadMoreButton.addEventListener('click', function () {
                  page++;
                  loadPhotos();
              });
          });
    </script>
            <!-- Our database search results section -->
            <!-- <div id="searchResults" class="searchresult">
                
            </div> -->
    <!-- End Hero Section -->
    <script>
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        var scrollThreshold = 230; 
        if (window.scrollY > scrollThreshold) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });
    </script>
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