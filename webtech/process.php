<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $stdName = trim($_POST['student']);
    $stdID = trim($_POST['studentid']);
    $books = $_POST['books'];
    $borrowDate = $_POST['borrowdate'];
    $token = trim($_POST['token']);
    $returnDate = $_POST['returndate'];

    // Validate that no field is empty
    if (empty($stdName) || empty($stdID) || empty($books) || empty($borrowDate) || empty($returnDate)) {
        echo "<p style='color: red;'>Please fill in all required fields.</p>";
    }
    // Validate the format of the student ID (xx-xxxxx-x, where x is a digit)
    elseif (!preg_match("/^\d{2}-\d{5}-\d{1}$/", $stdID)) {
        echo "<p style='color: red;'>Invalid Student ID format. The correct format is xx-xxxxx-x (e.g., 12-34567-8).</p>";
    }
    // Validate the username does not contain numbers
    elseif (preg_match("/\d/", $stdName)) {
        echo "<p style='color: red;'>Student Name cannot contain numbers.</p>";
    }
    // Validate that the borrow date is not in the past
    elseif (strtotime($borrowDate) < strtotime(date("Y-m-d"))) {
        echo "<p style='color: red;'>Borrow date cannot be in the past.</p>";
    }
    else {
        // Define valid tokens (add numeric tokens here)
        $tokenDiscounts = [
            "12345" => 10,
            "12346" => 90,
            "78995" => 20,
            "64556" => 30,
            "98761" => 15,
            "67890" => 10,
        ];
        
        // Generate valid tokens dynamically from token discounts
        $validTokens = array_keys($tokenDiscounts);
        
        // Check if the token is valid
        if (!in_array($token, $validTokens) && !empty($token)) {
            echo "<p style='color: red;'>Invalid token. Please enter a valid token.</p>";
        }
        else {
            // Cookie name based on the token
            $cookie_name = "token_used_" . preg_replace('/[^a-zA-Z0-9_]/', '_', $token);

            // Check if the token cookie already exists
            if (isset($_COOKIE[$cookie_name])) {
                echo "<p style='color: red;'>Token '$token' has already been used. Please use a different token.</p>";
            } 
            else {
                // Set the token cookie to prevent reuse 
                if(!empty($token))
                {
                    setcookie($cookie_name, "used", time() + 500);
                }

                // Calculate discount based on the token
                $discount = isset($tokenDiscounts[$token]) ? $tokenDiscounts[$token] : 0;

                // Determine the allowed return date based on the token
                $allowedReturnDays = $discount > 0 ? 30 : 10; // If token is valid, allow 30 days; else, only 10 days.

                // Calculate the date 10 or 30 days after the borrow date
                $maxReturnDate = date('Y-m-d', strtotime("+$allowedReturnDays days", strtotime($borrowDate)));

                // Validate that the return date is within the allowed range
                if (strtotime($returnDate) > strtotime($maxReturnDate)) {
                    echo "<p style='color: red;'>Return date cannot be more than $allowedReturnDays days after the borrow date.</p>";
                } else {
                    // Database connection details
                    $host = 'localhost'; // Adjust as needed
                    $username = 'root'; // Adjust as needed
                    $password = ''; // Adjust as needed
                    $dbname = 'book_database'; // Adjust as needed

                    // Create a connection
                    $conn = new mysqli($host, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("<p style='color: red;'>Database connection failed: " . $conn->connect_error . "</p>");
                    }

                    // Update the book quantity
                    $sql = "UPDATE books SET quantity = quantity - 1 WHERE book_title = ? AND quantity > 0";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $books);

                    if ($stmt->execute() && $stmt->affected_rows > 0) {
                        echo "<h3>Form Submitted Successfully!</h3>";
                        echo "<p><i>Student Name: $stdName</i></p>";
                        echo "<p>Student ID: $stdID</p>";
                        echo "<p>Book Selected: $books</p>";
                        echo "<p>Borrow Date: $borrowDate</p>";
                        echo "<p>Return Date: $returnDate</p>";
                        echo "<p>Token: $token</p>";
                        echo "<p><strong>Discount Applied: $discount%</strong></p>";
                    } else {
                        echo "<p style='color: red;'>Failed to borrow the book. Either the book is out of stock or an error occurred.</p>";
                    }

                    // Close the statement and connection
                    $stmt->close();
                    $conn->close();

                    // Add a button to go back to index.php
                    echo "<form action='index.php' method='get'>";
                    echo "<button type='submit'>Go Back to Index</button>";
                    echo "</form>";
                }
            }
        }
    }
} else {
    // Redirect back to the form if the page is accessed without submitting the form
    header('Location: index.php');
    exit();
}
?>
