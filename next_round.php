<?php
session_start();

// Increment the round if lives are remaining and rounds are less than 5
if ($_SESSION['lives'] > 0 && $_SESSION['round'] < 5) {
    //$_SESSION['round']++;
    header("Location: play_game.php");
} else {
    // Game over if lives are 0 or 5 rounds completed
    header("Location: game_over.php");
}
exit();
?>
