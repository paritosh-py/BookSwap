<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="POST" action="">
        Name: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit" name="register">Register</button>
    </form>

    <?php
    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Ensure that the email is unique
        $check_email = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($check_email);

        if ($result->num_rows > 0) {
            echo "This email is already registered. Please use a different email.";
        } else {
            // Insert the new user into the database
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

            if ($conn->query($sql)) {
                echo "Registration successful! <a href='login.php'>Login</a>";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
    ?>
</body>
</html>
