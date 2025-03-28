<?php
session_start();

// Check if session exists
$sessionAvailable = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banana Quest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link href="/banana-quest/frontend/assets/css/style.css" rel="stylesheet">
</head>
<body class="game-bg min-h-screen flex items-center justify-center p-4">
    <!-- CRT Effect -->
    <div class="crt-effect"></div>    
    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-2xl text-center flex flex-col items-center space-y-8">
<?php
if (!$sessionAvailable) {
    include 'http://localhost/banana-quest/frontend/pages/login.php'; // Relative path
} else {
    $page = isset($_GET['page']) ? $_GET['page'] : 'menu';
    switch ($page) {
        case 'game':
            include 'http://localhost/banana-quest/frontend/pages/game.php';
            break;
        case 'leaderboard':
            include 'http://localhost/banana-quest/frontend/pages/leaderboard.php';
            break;
        case 'profile':
            include 'http://localhost/banana-quest/frontend/pages/profile.php';
            break;
        case 'menu':
        default:
            include 'http://localhost/banana-quest/frontend/pages/menu.php';
            break;
    }
}
?>
    </div>