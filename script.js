function addIngredientField() {
    // Create a new div to group ingredient and value input fields
    var ingredientDiv = document.createElement("div");
    ingredientDiv.classList.add("ingredient-pair");

    // Create new input elements for ingredient and value
    var newIngredientLabel = document.createElement("label");
    newIngredientLabel.setAttribute("for", "ingredient");
    newIngredientLabel.textContent = "Ingredients:";
    
    var newIngredientField = document.createElement("input");
    newIngredientField.setAttribute("type", "text");
    newIngredientField.setAttribute("name", "ingredients[]");
    newIngredientField.required = true;

    var newValueLabel = document.createElement("label");
    newValueLabel.setAttribute("for", "value");
    newValueLabel.textContent = "Value:";
    
    var newValueField = document.createElement("input");
    newValueField.setAttribute("type", "text");
    newValueField.setAttribute("name", "values[]");
    newValueField.required = true;

    // Append labels and input fields to the div
    ingredientDiv.appendChild(newIngredientLabel);
    ingredientDiv.appendChild(newIngredientField);
    ingredientDiv.appendChild(newValueLabel);
    ingredientDiv.appendChild(newValueField);

    // Append the div to the "add-food-ingredients" container
    var ingredientsContainer = document.querySelector(".add-food-ingredients");
    ingredientsContainer.appendChild(ingredientDiv);
}