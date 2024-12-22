<?php
$servername = "localhost";  // This refers to your local server (XAMPP)
$username = "root";         // Default username for XAMPP
$password = "";             // Default password for XAMPP is empty
$dbname = "book_swap_db";   // Name of your database (book_swap_db)

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>