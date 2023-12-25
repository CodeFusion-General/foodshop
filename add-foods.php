<!DOCTYPE html>
<html lang="en">
<?php
$pageTitle = "Add Foods";
include"head.php";
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $ingredients = $_POST['ingredients'];
    $values = $_POST['values'];

    // Replace with actual user ID from session or authentication system
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        // Handle the case where the user is not logged in or session is not set
        echo "User is not logged in.";
        exit; // Or redirect to login page
    }

    // Insert recipe data into 'recipe' table
    $recipe_query = "INSERT INTO recipe (user_id, title, description) VALUES ('$user_id', '$title', '$description')";
    if ($conn->query($recipe_query) === TRUE) {
        $recipe_id = $conn->insert_id;

        // Insert each ingredient into 'recipe_ingredients' table
        for ($i = 0; $i < count($ingredients); $i++) {
            $ingredient = $conn->real_escape_string($ingredients[$i]);
            $value = $conn->real_escape_string($values[$i]);
            $ingredient_query = "INSERT INTO recipe_ingredients (recipe_id, ingredient, value) VALUES ('$recipe_id', '$ingredient', '$value')";
            $conn->query($ingredient_query);
        }

        // Handle photo upload
        $target_dir = "uploads/"; // Make sure this directory exists and is writable
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo_query = "INSERT INTO recipe_photo (recipe_id, photo) VALUES ('$recipe_id', '$target_file')";
            $conn->query($photo_query);
        }
    }
    $conn->close();
}
?>

<body>
<?php include("navbar.php"); ?>
<form id="add-foods" class="add-foods"action="add-foods.php" method="post" enctype="multipart/form-data">
    <label for="title">Recipe Title:</label>
    <input type="text" id="title" name="title" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>


    <div class="add-food-ingredients">
        <label for="ingredient">Ingredients:</label>
        <input type="text" id="ingredient" name="ingredients[]" required>
        <label for="value">Value:</label>
        <input type="text" id="value" name="values[]" required>
    </div>
    <button type="button" onclick="addIngredientField()">Add More Ingredients</button>

    <label for="photo">Photo:</label>
    <input type="file" id="photo" name="photo" required>

    <input type="submit" value="Add Recipe">
</form>

</body>
</html>