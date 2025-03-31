<?php
session_start();
require 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

// Get the JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['username']) || !isset($data['level']) || !isset($data['score']) || !isset($data['difficulty']) || !isset($data['bananas'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid or incomplete data']);
    exit;
}

// Ensure the username matches the session username for security
if ($data['username'] !== $_SESSION['username']) {
    echo json_encode(['status' => 'error', 'message' => 'Username mismatch']);
    exit;
}

try {
    // Get the user ID from the users table
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        exit;
    }

    $user_id = $user['id'];
    $score = (int)$data['score'];
    $action = $data['difficulty'].' Level';
    
    $details = 'Level ' . $data['level'] .' - '. $data['bananas'] . ' bananas collected';

    // Insert the game data into user_history
    $stmt = $pdo->prepare("
        INSERT INTO user_history (user_id, action, score, details, timestamp)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt->execute([$user_id, $action, $score, $details]);

    echo json_encode(['status' => 'success', 'message' => 'Game data saved successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>