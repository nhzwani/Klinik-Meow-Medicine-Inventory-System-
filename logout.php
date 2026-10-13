<?php

session_start();

// Buang semua session

session_unset();

session_destroy();

// Kembali ke login page

header("Location: login.php");

exit();

?>