<?php
// Start the session
session_start();

// Destroy the session to log the user out
session_destroy();

// Redirect the user to the home page (or login page)
header("Location: index.php"); // Or use header("Location: login.php") if you have a login page
exit();
?>