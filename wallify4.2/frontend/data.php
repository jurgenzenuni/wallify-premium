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

$sql = "SELECT search_term, search_count FROM search_logs";

$result = $conn->query($sql);

$search_data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $search_data[] = array("search_term" => $row["search_term"], "search_count" => $row["search_count"]);
    }
} else {
    echo "0 results";
}

$conn->close();

$search_json = json_encode($search_data);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Term Chart</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
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
            font-family: "Ubuntu", sans-serif;
        }
        canvas {
            max-width: 3000px;
            margin: 20px auto;
            display: block;
        }
        #sortButton {
            display: block;
            margin: 20px auto 20px;
            padding: 12px 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: black;
            color: #fff;
            cursor: pointer;
        }
        #sortButton:hover {
            background-color: #55bcc9;
            transition: 0.5s ease-in-out;
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
                    <a class="nav-link mx-lg-2" href="aboutpg.php">About</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<button id="sortButton" onclick="sortData()">Sort Ascending</button>
<canvas id="searchChart" width="1600" height="1000"></canvas>

<script>
// Retrieve search data from PHP variable
var searchData = <?php echo $search_json; ?>;

// Extract search terms and counts
var labels = searchData.map(function(item) {
    return item.search_term;
});
var data = searchData.map(function(item) {
    return item.search_count;
});

// Create a bar chart using Chart.js
var ctx = document.getElementById('searchChart').getContext('2d');
var searchChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Search Count',
            data: data,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Function to sort data
function sortData() {
    searchData.sort(function(a, b) {
        return a.search_count - b.search_count; // Sort in ascending order
    });

    // Update button text based on sorting order
    var sortButton = document.getElementById('sortButton');
    if (sortButton.textContent === 'Sort Ascending') {
        sortButton.textContent = 'Sort Descending';
    } else {
        sortButton.textContent = 'Sort Ascending';
        searchData.reverse(); // Reverse the array to sort in descending order
    }

    // Update chart data and labels
    searchChart.data.labels = searchData.map(function(item) {
        return item.search_term;
    });
    searchChart.data.datasets[0].data = searchData.map(function(item) {
        return item.search_count;
    });

    // Update chart
    searchChart.update();
}
</script>

</body>
</html>
