<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Level</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Extra Title Container -->
    <div class="extratitle-container">
        <h1 class="extra">Select the Level</h1>
    </div>

    <div class="choose-level-container">
        <form method="POST" action="play_game.php">
            <button class="level-btn easy-btn" name="level" value="easy">Easy</button>
            <button class="level-btn medium-btn" name="level" value="medium">Medium</button>
            <button class="level-btn high-btn" name="level" value="high">High</button>
        </form>
        <form method="POST" action="menu.php">
            <button class="exit-btn">Exit</button>
        </form>
    </div>
</body>
</html>
