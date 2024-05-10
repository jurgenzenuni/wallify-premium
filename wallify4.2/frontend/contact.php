<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Lobster&family=Pacifico&family=Poppins:wght@500&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="./css/contact.css" rel="stylesheet">
</head>
<body>

<header class="header">
        <div class="logo logomargins">
            <a href="home.php">
                <img src="./images/wlogo4.png" alt="Logo">
            </a>
        </div>
    </header>
    <!-- <h2 class="title3"> Login </h2>
        <div class="centered-text"> -->
    <form method="post" action="../backend/email.php">
        <h2 class="title2"> Contact Us </h2>
        <label for="name"></label>
        <input type="text" id="name" name="name" placeholder="Your name">

        <label for="email"></label>
        <input type="email" id="email" name="email" placeholder="Your email address">

        <label for="reason"></label>
        <select id="reason" name="reason">
            <option value="" disabled selected>Please select</option>
            <!-- <option class="ps" value="question">Please Select</option> -->
            <option value="issue">Issue</option>
            <option value="suggestion">Suggestion</option>
            <option value="other">Other</option>
        </select>

        <label for="details"></label>
        <textarea id="details" name="details" placeholder="Please describe your question or issue you're experiencing."></textarea>

        <button class="buttonsubmit" type="submit">Submit</button>
        <!-- <button class="buttongoback" type="submit" onclick="window.location.href='home.php'" >Go back</button> -->
        <a class="nav-link mx-lg-2 contact-back" href="home.php"> Go back </a>
    </form>
</body>
</html>