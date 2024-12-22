<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $requester_id = $_SESSION['user_id'];

    // Insert the request into the `requests` table
    $sql = "INSERT INTO requests (book_id, requester_id, status) VALUES ('$book_id', '$requester_id', 'Pending')";
    if ($conn->query($sql)) {
        echo "<script>alert('Request sent successfully!'); window.location.href='start_swapping.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header('Location: start_swapping.php');
    exit;
}
?>
