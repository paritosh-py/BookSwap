<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';
$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    // Check if the request already exists
    $check_sql = "SELECT * FROM requests WHERE requester_id = '$user_id' AND book_id = '$book_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $message = "You have already requested this book!";
    } else {
        // Insert the request
        $sql = "INSERT INTO requests (requester_id, book_id, status) VALUES ('$user_id', '$book_id', 'Pending')";
        if ($conn->query($sql)) {
            $message = "Request submitted successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Status</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Popup styling */
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            z-index: 1000;
            display: none;
        }

        .popup h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .popup button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .popup button:hover {
            background-color: #0056b3;
        }

        /* Overlay styling */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }
    </style>
</head>
<body>
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2><?php echo $message; ?></h2>
        <button onclick="redirect()">Okay</button>
    </div>

    <script>
        // Show the popup
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('popup').style.display = 'block';

        // Redirect after clicking Okay
        function redirect() {
            window.location.href = 'start_swapping.php';
        }
    </script>
</body>
</html>
