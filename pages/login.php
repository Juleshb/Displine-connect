<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once "../connection.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginIdentifier = $_POST["login_identifier"];
    $password = $_POST["password"];

    // Query the database to find a matching user
    $query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $loginIdentifier, $loginIdentifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            // Password matches, set session and redirect based on role
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["role"] = $user["role"];

            // Redirect to appropriate dashboard
            if ($user["role"] == "admin") {
                header("Location:../gradians/nav.php"); // Redirect to admin dashboard
            } elseif ($user["role"] == "user") {
                header("Location:../metron.php"); // Redirect to user dashboard
            }
            exit();
        }
    }

    // If login fails, redirect back to the login form with an error message
    header("Location: sign-in.html"); // Redirect with an error message
    exit();
}
?>
