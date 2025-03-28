<?php
session_start();
require 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';

if (strlen($new_password) < 8) {
    echo json_encode(['status' => 'error', 'message' => 'New password must be at least 8 characters long']);
    exit;
}

try {
    // Fetch current password hash
    $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $current_hash = $stmt->fetchColumn();

    if (!$current_hash || !password_verify($current_password, $current_hash)) {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect current password']);
        exit;
    }

    // Hash new password and update
    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->execute([$new_hash, $_SESSION['username']]);

    echo json_encode(['status' => 'success', 'message' => 'Password updated successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>