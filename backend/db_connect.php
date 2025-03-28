<?php
// Database configuration
$host = 'localhost';
$dbname = 'banana_quest';
$username = 'root';
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Return a JSON error response if connection fails
    die(json_encode(['success' => false, 'error' => 'Database connection failed: ' . $e->getMessage()]));
}
?>