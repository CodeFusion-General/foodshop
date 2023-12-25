<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_unset();
session_destroy();

// Redirect to the login page after logout with a success message
header("Location: login.php?logout=1");
exit();
?>
