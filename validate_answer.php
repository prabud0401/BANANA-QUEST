<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userAnswer = $_POST['answer'];
    $correctAnswer = $_SESSION['solution'];

    // Debug session data
    // var_dump($_SESSION); die();

    // Validate the answer
    if ($userAnswer == $correctAnswer) {
        $_SESSION['score'] += 5; // Increment score if correct
    } else {
        $_SESSION['lives'] -= 1; // Deduct a life if incorrect
    }

    // Proceed to the next round
    $_SESSION['round'] += 1; // Increment round counter

    // Check for game over conditions
    if ($_SESSION['lives'] <= 0 || $_SESSION['round'] > 5) {
        // Record game stats in the database
        $username = $_SESSION['username'];
        $finalScore = $_SESSION['score'];
        $winCondition = ($_SESSION['round'] >= 5 && $_SESSION['lives'] > 0); // Player survives all rounds

        // Update player's games played and wins (if applicable)
        $query = "UPDATE player_form
                  SET games_played = games_played + 1, 
                      games_won = games_won + IF(?, 1, 0) 
                  WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $winCondition, $username);
        $stmt->execute();

        $stmt->close();
        header("Location: game_over.php");
        exit();
    }

    header("Location: play_game.php");
    exit();
}
?>