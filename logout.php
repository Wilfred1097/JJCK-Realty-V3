<?php
// Start the session
session_start();

// Clear the user_token cookie to logout the user
setcookie('user_token', '', time() - 3600, '/'); // Set expiration time to past

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or any other desired page
header("Location: index.php");
exit();
?>
