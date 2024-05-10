<?php

session_start();

session_destroy();

header("Location: ../frontend/home.php");
exit;
?>
