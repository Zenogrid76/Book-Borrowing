<?php
echo "<h1>THIS IS PROCESS.PHP</h1>";

if (!empty(trim($_POST['student'])))
{ 
echo "Hello ".$_POST['student'];
}
else {echo "No data provided";}


if (preg_match("/^\d{2}-\d{5}-\d{1}$/", $_POST['studentid'])) {
    echo "<br>";
    echo "ID ".$_POST['studentid'];
}
else  {
    echo "not a valid id";
}




$cookie_name = "book_title"

if (isset($_POST['student'])) {
    $cookie_value= $_POST['student'];
    }


?>

