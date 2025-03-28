<?php
session_start();
require 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM user_history WHERE user_id = (SELECT id FROM users WHERE username = ?)");
    $stmt->execute([$_SESSION['username']]);
    echo json_encode(['status' => 'success', 'message' => 'History cleared']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>