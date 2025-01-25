<?php
// Database connection details
$host = 'localhost'; // Change this if your database is hosted elsewhere
$username = 'root'; // Update with your DB username
$password = ''; // Update with your DB password
$dbname = 'book_database'; // Name of your database

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $bookTitle = trim($_POST['book_title']);
    $isbnNumber = trim($_POST['isbn_number']);
    $quantity = intval($_POST['quantity']);
    $category = trim($_POST['category']);

    // Validate data
    if (empty($bookTitle) || empty($isbnNumber) || empty($quantity) || empty($category)) {
        echo "<p style='color: red;'>All fields are required. Please fill in the form completely.</p>";
    } elseif (!preg_match('/^\d{10}|\d{13}$/', $isbnNumber)) {
        echo "<p style='color: red;'>Invalid ISBN number. It must be 10 or 13 digits long.</p>";
    } else {
        // Prepare the SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO books (book_title, isbn_number, quantity, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $bookTitle, $isbnNumber, $quantity, $category);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Book data saved successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error saving book data: " . $stmt->error . "</p>";
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>
