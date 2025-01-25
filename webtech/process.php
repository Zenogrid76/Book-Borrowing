<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Get the form data
    $stdName = trim($_POST['student']);
    $stdID = trim($_POST['studentid']);
    $books = $_POST['books'];
    $borrowDate = $_POST['borrowdate'];
    $returnDate = $_POST['returndate'];
    $token = trim($_POST['token']);

    // Predefined valid tokens and their respective discounts
    $validTokens = [
        "SAVE10" => 10,
        "DISCOUNT20" => 20,
        "OFFER15" => 15,
    ];

    $discount = 0;

    // Validate that no field is empty
    if (empty($stdName) || empty($stdID) || empty($books) || empty($borrowDate) || empty($returnDate)) {
        echo "<p style='color: red;'>Please fill in all required fields.</p>";
    } 
    // Ensure student name does not contain numbers
    elseif (preg_match('/\d/', $stdName)) {
        echo "<p style='color: red;'>Student Name cannot contain numbers. Please enter a valid name.</p>";
    }
    // Validate the format of the student ID (xx-xxxxx-x, where x is a digit)
    elseif (!preg_match("/^\d{2}-\d{5}-\d{1}$/", $stdID)) {
        echo "<p style='color: red;'>Invalid Student ID format. The correct format is xx-xxxxx-x (e.g., 12-34567-8).</p>";
    } 
    // Validate that the borrow date is not in the past
    elseif (strtotime($borrowDate) < strtotime(date('Y-m-d'))) {
        echo "<p style='color: red;'>Borrow Date cannot be in the past. Please select a valid date.</p>";
    } 
    // Validate token and calculate discount
    elseif (!empty($token) && !array_key_exists($token, $validTokens)) {
        echo "<p style='color: red;'>Invalid token entered. Please use a valid discount token.</p>";
    } 
    else {
        if (!empty($token)) {
            $discount = $validTokens[$token];
        }

        // Display the form submission results
        echo "<h3>Form Submitted Successfully!</h3>";
        echo "<p><i>Student Name: $stdName</p>";
        echo "<p>Student ID: $stdID</p>";
        echo "<p>Book Selected: $books</p>";
        echo "<p>Borrow Date: $borrowDate</p>";
        echo "<p>Return Date: $returnDate</i></p>";
        if ($discount > 0) {
            echo "<p><strong>Discount Token:</strong> $token (Discount: $discount%)</p>";
        } else {
            echo "<p>No discount token applied.</p>";
        }

        // Handle book borrowing cookies
        $cookie_name = preg_replace('/[^a-zA-Z0-9_]/', '_', $books); 
        $cookie_value = $stdName; 
        
        if (isset($_COOKIE[$cookie_name])) { 
            echo "<p style='color: red;'>The book '$books' is already borrowed </p>"; 
        } 
        else {
            setcookie($cookie_name, $cookie_value, time() + 15);

            if (!isset($_COOKIE[$cookie_name])) {             
                echo "<p>No cookie available.</p>"; 
            } 
        }

        // Store used token in a cookie for later display (if valid)
        if (!empty($token) && $discount > 0) {
            setcookie("used_token_$token", $token, time() + 30);
        }
    }
} 
else 
{
    // Redirect back to the form if the page is accessed without submitting the form
    header('Location: index.php');
    exit();
}
?>
