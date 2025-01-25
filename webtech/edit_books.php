<?php
// Database connection details
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$dbname = 'book_database';

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        // Update the selected book
        $id = intval($_POST['update']);
        $bookTitle = trim($_POST['book_title'][$id]);
        $isbnNumber = trim($_POST['isbn_number'][$id]);
        $quantity = intval($_POST['quantity'][$id]);
        $category = trim($_POST['category'][$id]);

        if (!empty($bookTitle) && !empty($isbnNumber) && !empty($category) && $quantity >= 0) {
            $stmt = $conn->prepare("UPDATE books SET book_title=?, isbn_number=?, quantity=?, category=? WHERE id=?");
            $stmt->bind_param("ssisi", $bookTitle, $isbnNumber, $quantity, $category, $id);
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Book with ID $id updated successfully!</p>";
            } else {
                echo "<p style='color: red;'>Error updating book: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p style='color: red;'>Invalid input data. All fields are required and quantity must be non-negative.</p>";
        }
    } elseif (isset($_POST['delete'])) {
        // Delete the selected book
        $id = intval($_POST['delete']);
        $stmt = $conn->prepare("DELETE FROM books WHERE id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Book with ID $id deleted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error deleting book: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Close the connection
$conn->close();

// Redirect back to the previous page
header('Location: index.php');
exit();
?>
