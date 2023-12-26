<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";  // Update with your password, if any
$dbname = "foodshop";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id']) || !isset($_POST['comment']) || !isset($_POST['recipe_id'])) {
    // Handle not logged in, or missing data
    $conn->close(); // Close the database connection
    header('Location: ../login.php');
    exit;
}

$comment = $conn->real_escape_string($_POST['comment']);
$recipe_id = intval($_POST['recipe_id']);
$user_id = $_SESSION['user_id'];

$insert_sql = "INSERT INTO comments (recipe_id, user_id, comment) VALUES ('$recipe_id', '$user_id', '$comment')";
$conn->query($insert_sql);

$conn->close(); // Close the database connection

header('Location: ../food-details.php?id=' . $recipe_id); // Redirect back to the food details page
exit;
?>
