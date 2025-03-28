<?php
// fetch_users_data.php
require 'db_connect.php';

header('Content-Type: application/json'); // Ensure the response is in JSON format

try {
    // Query to fetch top 10 users and their total scores
    $stmt = $pdo->prepare("
        SELECT u.username, COALESCE(SUM(h.score), 0) as score
        FROM users u
        LEFT JOIN user_history h ON u.id = h.user_id
        GROUP BY u.id, u.username
        ORDER BY score DESC
        LIMIT 10
    ");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the result as JSON
    echo json_encode($users);

} catch (PDOException $e) {
    // Return an error response as JSON
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>