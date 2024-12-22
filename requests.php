<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';
$user_id = $_SESSION['user_id'];

// Fetch requests where the logged-in user is the owner of the book
$sql = "SELECT requests.id, books.book_name, users.name AS requester_name, users.email AS requester_email, requests.status 
        FROM requests 
        INNER JOIN books ON requests.book_id = books.id 
        INNER JOIN users ON requests.requester_id = users.id 
        WHERE books.user_id = '$user_id'";
$result = $conn->query($sql);

$requestDetails = null;

// Handle Approve Action
if (isset($_POST['approve'])) {
    $request_id = $_POST['approve'];
    $requester_name = $_POST['requester_name'];
    $requester_email = $_POST['requester_email'];

    $sql = "UPDATE requests SET status = 'Approved' WHERE id = '$request_id'";
    if ($conn->query($sql)) {
        // Pass details to JavaScript for the popup
        $requestDetails = [
            "name" => $requester_name,
            "email" => $requester_email,
        ];
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Handle Reject Action
if (isset($_POST['reject'])) {
    $request_id = $_POST['reject'];
    $sql = "UPDATE requests SET status = 'Rejected' WHERE id = '$request_id'";
    if (!$conn->query($sql)) {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Requests</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // JavaScript function to show the popup
        function showPopup(name, email) {
            alert(`Request Approved!\nRequester Name: ${name}\nRequester Email: ${email}`);
        }
    </script>
</head>
<body>
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="add_books.php">Add Books</a>
        <a href="start_swapping.php">Start Swapping</a>
        <a href="requests.php">Your Requests</a>
        <a href="requests_status.php">Request Status</a>
        <a href="profile.php">Personal Details</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <h2>Your Book Requests</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div>";
                echo "<h3>" . $row['book_name'] . "</h3>";
                echo "<p>Requester: " . $row['requester_name'] . "</p>";
                echo "<p>Status: " . $row['status'] . "</p>";
                echo "<form method='POST' action=''>
                        <input type='hidden' name='requester_name' value='" . $row['requester_name'] . "'>
                        <input type='hidden' name='requester_email' value='" . $row['requester_email'] . "'>
                        <button type='submit' name='approve' value='" . $row['id'] . "'>Approve</button>
                        <button type='submit' name='reject' value='" . $row['id'] . "'>Reject</button>
                      </form>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>You have no book requests.</p>";
        }

        // Trigger popup if request details are available
        if ($requestDetails) {
            echo "<script>
                showPopup('" . $requestDetails['name'] . "', '" . $requestDetails['email'] . "');
            </script>";
        }
        ?>
    </div>
</body>
</html>
