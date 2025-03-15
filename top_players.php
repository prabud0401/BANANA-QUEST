<?php
session_start();

// Connect to the database
require 'config.php';

$query = "SELECT username, score FROM player_form ORDER BY score DESC LIMIT 3";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Top 3 Players</title>
</head>
<body>
    <div class="extratitle-container">
        <h1>Top 3 Players</h1>
    </div>
    <div class="menu-container">
        <ol>
            <?php while ($row = $result->fetch_assoc()): ?>
            <li><strong><?php echo $row['username']; ?></strong> - Final Highest Score: <?php echo $row['score']; ?></li>
            <?php endwhile; ?>
        </ol>
    </div>
    <div class="button-container">
        <button class="back-home-button" onclick="window.location.href='menu.php';">Back to Menu</button>
    </div>
</body>
</html>
<?php $conn->close(); ?>
