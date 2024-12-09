<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root"; // Database username
    $password = ""; // Database password
    $dbname = "learn_to_code"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize input
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);

    // Check if username already exists
    $sql_check = "SELECT * FROM users WHERE username = '$user' OR email = '$email'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        echo "<script>alert('Username or Email already exists.');</script>";
    } else {
        // Insert the new user into the database
        $sql_insert = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$pass')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "<script>alert('Account created successfully!'); window.location.href = 'index.html';</script>";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>