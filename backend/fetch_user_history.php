<?php
session_start();
require 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT action, score, details, timestamp 
        FROM user_history 
        WHERE user_id = (SELECT id FROM users WHERE username = ?) 
        ORDER BY timestamp DESC
    ");
    $stmt->execute([$_SESSION['username']]);
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($history);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>