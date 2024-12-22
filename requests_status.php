<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';
$user_id = $_SESSION['user_id'];

// Fetch approved requests where the logged-in user is the requester
$sql = "SELECT books.book_name, books.author, users.name AS owner_name, users.email AS owner_email 
        FROM requests 
        INNER JOIN books ON requests.book_id = books.id 
        INNER JOIN users ON books.user_id = users.id 
        WHERE requests.requester_id = '$user_id' AND requests.status = 'Approved'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Status</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="add_books.php">Add Books</a>
        <a href="start_swapping.php">Start Swapping</a>
        <a href="requests.php">Your Requests</a>
        <a href="requests_status.php">Request Status</a> <!-- New Tab -->
        <a href="profile.php">Personal Details</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <h2>Approved Requests</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='approved-request'>";
                echo "<h3>Book: " . $row['book_name'] . "</h3>";
                echo "<p>Author: " . $row['author'] . "</p>";
                echo "<p>Owner: " . $row['owner_name'] . "</p>";
                echo "<p>Email: " . $row['owner_email'] . "</p>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>No approved requests yet.</p>";
        }
        ?>
    </div>
</body>
</html>
