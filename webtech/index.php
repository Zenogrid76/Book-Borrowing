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
            if (str_starts_with($key, "used_token_")) {
                echo "<li>" . htmlspecialchars($value) . "</li>";
            }
        }
        ?>
            </ul>
        </div>


        <div class="outside2">
        <div class="banner1">

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
                                die("<p style='color: red;'>Database connection failed: " . $conn->connect_error . "</p>");
                            }

                            // Fetch all available books
                            $sql = "SELECT book_title, isbn_number, quantity, category FROM books";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<h2>Available Books</h2>";
                                echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; text-align: left;'>";
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
    $host = 'localhost'; // Change this if necessary
    $username = 'root'; // Update with your DB username
    $password = ''; // Update with your DB password
    $dbname = 'book_database'; // Name of your database

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
        echo "<table class='book-table'>";
        echo "<tr>
                <th>Title</th>
                <th>ISBN</th>
                <th>Quantity</th>
                <th>Category</th>
                <th>Actions</th>
              </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
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
                    <select name="books" id="book" >
                    <option value="Anna_Karenina">Anna Karenina </option>
                    <option value="Madame_Bovary">Madame Bovary</option>
                    <option value="War_and_Peace">War and Peace</option>
                    <option value="The_Great_Gatsby">The Great Gatsby</option>
                    <option value="Lolita">Lolita</option>
                    <option value="Middlemarch">Middlemarch</option>
             
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
                <p>Lorem ipsum dolor sit.</p>
            </div>


        </div>
        <div class="leftbanner">
          <! --<img src="banner.jpg" height=auto width=194 ;>
    
        </div>

    </div>


</body>