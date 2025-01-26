<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOK Borrowing WEBSITE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    </head>
    <link rel="stylesheet" href="styles.css">
</head>




<body>

    <img src="id mahim.PNG" height=auto width=auto ;>
   
    <div class="mainoutside">

        <div class="leftbanner">
        <h3>Used Tokens</h3>
        <ul>
        <?php
        foreach ($_COOKIE as $key => $value) {
            if (str_starts_with($key, "token_used_")) { // Correct prefix
                echo "<li>" . htmlspecialchars(str_replace("token_used_", "", $key)) . "</li>";
            }
        }
        ?>
        </ul>
        </div>


        <div class="outside2">
        <div class="banner1">
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
        die("<p style='color: red;'>Database connection failed: " . $conn->connect_error . "</p>");
    }

    // Fetch all available books
    $sql = "SELECT book_title, isbn_number, quantity, category FROM books";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Available Books</h2>";
        echo "<div class='scrollable-table'>";
        echo "<table class='book-table'>";
        echo "<tr>
                <th>Title</th>
                <th>ISBN</th>
                <th>Quantity</th>
                <th>Category</th>
              </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['book_title']}</td>
                    <td>{$row['isbn_number']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['category']}</td>
                  </tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p>No books available in the database.</p>";
    }

    // Close the connection
    $conn->close();
    ?>
</div>


            <div class="banner12"> 
    <h2>Manage Book Database</h2>
    
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
        die("<p style='color: red;'>Database connection failed: " . $conn->connect_error . "</p>");
    }

    // Fetch all available books
    $sql = "SELECT id, book_title, isbn_number, quantity, category FROM books";
    $result = $conn->query($sql);

    // Check if the query was successful
    if (!$result) {
        die("<p style='color: red;'>Query failed: " . $conn->error . "</p>");
    }

    // Check if any books are found
    if ($result->num_rows > 0) {
        // Display books in a table with inputs for editing
        echo "<form action='edit_books.php' method='post'>";
        echo "<div class='scrollable-table'>"; // Wrapper for scrollable area
        echo "<table class='book-table'>";
        echo "<tr>
        <th>ID</th>
                <th>Title</th>
                <th>ISBN</th>
                <th>Quantity</th>
                <th>Category</th>
                <th>Actions</th>
              </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
            <td><input type='text' name='ID[{$row['id']}]' value='{$row['id']}'></td>
                    <td><input type='text' name='book_title[{$row['id']}]' value='{$row['book_title']}'></td>
                    <td><input type='text' name='isbn_number[{$row['id']}]' value='{$row['isbn_number']}'></td>
                    <td><input type='number' name='quantity[{$row['id']}]' value='{$row['quantity']}'></td>
                    <td><input type='text' name='category[{$row['id']}]' value='{$row['category']}'></td>
                    <td>
                        <button type='submit' name='update' value='{$row['id']}'>Update</button>
                        <button type='submit' name='delete' value='{$row['id']}'>Delete</button>
                    </td>
                  </tr>";
        }
        echo "</table>";
        echo "</div>"; // Close scrollable wrapper
        echo "</form>";
    } else {
        echo "<p>No books available to manage. Please add books to the database.</p>";
    }

    // Close the connection
    $conn->close();
    ?>
</div>




            <div class="contents">
                <div class="container">
                    <img src="Book1.jpg" height=auto width=auto ;>
                </div>

                <div class="container">
                    <img src="Book2.png" height=auto width=auto>
                    
                </div>

                <div class="container">
                    <img src="Book3.jpg" height=auto width=auto>
                    
                    
                </div>
            </div>


            <div class="banner2">

                 <h2>ADD BOOKS TO DATABASE <h2>
                    <form action="save_book.php" method="post">
                    <label for="book_title">Book Title:</label>
                    <input type="text" id="book_title" name="book_title" placeholder="Enter book title" required>
                    <br><br>

                    <label for="isbn_number">ISBN Number:</label>
                    <input type="text" id="isbn_number" name="isbn_number" placeholder="Enter ISBN number" required>
                    <br><br>

                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required>
                    <br><br>

                    <label for="category">Category:</label>
                    <input type="text" id="category" name="category" placeholder="Enter category" required>
                    <br><br>

                    <input type="submit" value="Save Book">
                    </form>
            </div>


            <div class="container2">
                <h3 style="text-align:center" >Borrow Form</h3>


                <form action="process.php" method="post">
                    <input type="Text" name="student" id="stdnm" placeholder="Student Name" size="33" >
                    <br>
                    <br>
                    <label for="stid" >Student-ID: </label>
                    <input type="Text" name="studentid" id="stid" placeholder="Student ID"><br>
                    
                    <br>

                    <label for="books">Choose a Book: </label>
<select name="books" id="book">
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
        die("<p style='color: red;'>Database connection failed: " . $conn->connect_error . "</p>");
    }

    // Fetch all available books
    $sql = "SELECT id, book_title, quantity FROM books WHERE quantity > 0"; // Only fetch books with quantity > 0
    $result = $conn->query($sql);

    // Check if any books are available
    if ($result->num_rows > 0) {
        // Loop through the books and create options
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['book_title']}'>{$row['book_title']}</option>";
        }
    } else {
        echo "<option value=''>No books available</option>";
    }

    // Close the connection
    $conn->close();
    ?>
</select>

                    
                    <br><br>
                    <label for="borrowdate">Borrow Date:</label>
                    <input type="date" id="borrowdate" name="borrowdate">
                    <input type="text"  name="token" id="tokenid" placeholder="token" size="3">
                    <br><br>
                    <label for="returndate">Return Date:</label>
                    <input type="date" id="returndate" name="returndate">
                    <br><br>
                    
                 
                    <input type="submit" value="Submit">
                    <input type="button" value="Cancel">


                </form>
            </div>


            <div class="container2">
                <h2>AVAILABLE TOKENS </h2>
                <br>12345 
                <br>78995
                <br>64556
                <br>98761 
                <br>12346
                <br>67890



            </div>


        </div>
        <div class="rightbanner">
        Book borrowing management is an essential system used by libraries, schools, and other organizations to efficiently manage the lending and returning of books. It involves tracking the availability of books, monitoring who borrows them, ensuring timely returns, and managing overdue items. Effective book borrowing management helps improve inventory control, reduce losses, and enhance user experience by allowing borrowers to easily access and return books. Modern systems often include digital catalogs, reservation features, and automated reminders to streamline the entire process, making it easier for both librarians and readers.




    
        </div>

    </div>


</body>