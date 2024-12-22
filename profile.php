<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';
$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT name, email FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Personal Details</title>
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
        <h2>Your Personal Details</h2>
        <?php if ($user) { ?>
            <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <?php } else { ?>
            <p>No details found for your account.</p>
        <?php } ?>
    </div>
</body>
</html>
