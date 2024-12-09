<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root"; // Database username
    $password = ""; // Database password
    $dbname = "ThecakeRoom"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize input
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if username exists
    $sql_check = "SELECT * FROM users WHERE username = '$user'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user'] = $user; // Store user session
            echo "<script>alert('Successfully logged in!'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href = 'index123.html';</script>";
        }
    } else {
        echo "<script>alert('Username not found. Please check your details.'); window.location.href = 'index.html';</script>";
    }

    $conn->close();
}
?>