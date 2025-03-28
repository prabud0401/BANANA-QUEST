<?php
// db_connect.php
$host = 'localhost';
$dbname = 'banana_quest';
$username = 'root'; // Change this if you have a different DB user
$password = ''; // Change this to your actual DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>