<?php
// logout.php
session_start(); // Start the session to access and destroy it

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the login page
header('Location: http://localhost/banana-quest/frontend/index.php');
exit;
?>