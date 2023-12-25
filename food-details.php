<!DOCTYPE html>
<html lang="en">
    <?php
    include 'head.php';
    $pageTitle = "Index";
    ?>
<body>
    <?php include ("navbar.php") ?>
    
    <div class="food-details">
        <?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "foodshop";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($recipe_id > 0) {
            // Fetch food details
            $sql = "SELECT * FROM recipe WHERE id = $recipe_id";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h1>" . $row["title"] . "</h1>";
                echo "<p>" . $row["description"] . "</p>";

                // Fetch ingredients
                $ingredient_sql = "SELECT * FROM recipe_ingredients WHERE recipe_id = $recipe_id";
                $ingredient_result = $conn->query($ingredient_sql);
                if ($ingredient_result && $ingredient_result->num_rows > 0) {
                    echo "<h2>Ingredients</h2><ul>";
                    while($ingredient_row = $ingredient_result->fetch_assoc()) {
                        echo "<li>" . $ingredient_row["ingredient"] . ": " . $ingredient_row["value"] . "</li>";
                    }
                    echo "</ul>";
                }

                // Fetch photo
                $photo_sql = "SELECT * FROM recipe_photo WHERE recipe_id = $recipe_id";
                $photo_result = $conn->query($photo_sql);
                if ($photo_result && $photo_result->num_rows > 0) {
                    $photo_row = $photo_result->fetch_assoc();
                    echo "<img src='data:image/jpeg;base64," . base64_encode($photo_row['photo']) . "' alt='Food Photo'>";
                }
            } else {
                echo "<p>Food item not found.</p>";
            }
        } else {
            echo "<p>Invalid Food ID.</p>";
        }
        $conn->close();
        ?>
    </div>


</body>
</html>