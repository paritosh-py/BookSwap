<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';

    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO books (user_id, book_name, author) VALUES ('$user_id', '$book_name', '$author')";
    if ($conn->query($sql)) {
        $success = "Book added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Books</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="navbar">
    <a href="home.php">Home</a>
    <a href="add_books.php">Add Books</a>
    <a href="start_swapping.php">Start Swapping</a>
    <a href="requests.php">Your Requests</a>
    <a href="profile.php">Personal Details</a> <!-- New link to profile -->
    <a href="logout.php">Logout</a>
</div>
    <div class="content">
        <h2>Add Your Books to Swap</h2>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <label for="book_name">Book Name:</label>
            <input type="text" id="book_name" name="book_name" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>

            <button type="submit">Add Book</button>
        </form>
    </div>
</body>
</html>
