<?php
// login.php
session_start(); // Start the session
require 'db_connect.php';

header('Content-Type: application/json'); // Ensure the response is in JSON format

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields.']);
        exit;
    }

    try {
        // Check if the user exists in the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Start session and set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Successful login
            echo json_encode(['status' => 'success', 'message' => 'Welcome back, ' . $username . '!']);
        } else {
            // Invalid credentials
            echo json_encode(['status' => 'error', 'message' => 'Invalid Monkey Name or Banana Code.']);
        }
    } catch (PDOException $e) {
        // Return an error response as JSON
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
}
?>