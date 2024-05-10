<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Lobster&family=Pacifico&family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/styles.css">
    <style>
.logo {
    position: absolute;
    top: 1px; 
    left: 1px; 
    margin-top: -9px;
    margin-left: -14px;
}

.logo img {
    width: 100px; /* Adjust the width as needed */
    height: auto; /* Maintain aspect ratio */
}
@media (max-width: 720px) {
            .formlogin {
            max-width: 400px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo logomargins">
            <a href="home.php">
                <img src="./images/wlogo4.png" alt="Logo">
            </a>
        </div>
    </header>

    <!-- <div class="login-container">
    <a href="home.php" class="close-button">X</a> -->
    <form class="formlogin" action="../backend/login.php" method="post">
        <h2 class="title2"> Login </h2>

		<!-- <label for="email"></label>
		<input type="email" id="email" name="email" required placeholder="Email"><br><br> -->

        <label for="username"></label>
		<input type="text" id="username" name="username" required placeholder="Username"><br><br>

		<label for="password"></label>
		<input type="password" id="password" name="password" required placeholder="Password"><br><br>

        <div class="remember-me">
            <input type="checkbox" name="remember">
            <label for="remember">Remember Me</label>
        </div><br><br>

        <input type="submit" value="Login" class="buttonlogin">

        <?php
        session_start();

        $error_message = isset($_GET['error_message']) ? $_GET['error_message'] : '';

        if (!empty($error_message)) {
            echo '<p style="color: red; text-align: center; margin-bottom: -15px;">' . $error_message . '</p>';
        }
        ?>

        <p class="fyp2"> 
            <span class="fyp2-text">Don't have an account?</span>
            <a href="signup.html" class="signup-btn">Sign up</a>
        </p>
    </form>
    <!-- </div> -->
   

    
</body>
</html>

