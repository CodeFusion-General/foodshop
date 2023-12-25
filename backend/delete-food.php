<?php
session_start();

// Check if user is logged in and has the right privileges
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page
    exit;
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodshop";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get food ID from URL
$food_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($food_id > 0) {
    // SQL to delete the food item
    $sql = "DELETE FROM recipe WHERE id = $food_id";

    if ($conn->query($sql) === TRUE) {
        echo "Food item deleted successfully.";
        // Optional: Redirect to another page after deletion
        header("Location: ../my-foods.php");
    } else {
        echo "Error deleting food item: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
