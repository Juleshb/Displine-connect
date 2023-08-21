<?php
require_once "../connection.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password securely before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user data into the database
    $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        // Registration successful, redirect to login page or other success page
        header("Location: sign-in.html");
        exit();
    } else {
        // Registration failed, handle the error (e.g., display an error message)
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
