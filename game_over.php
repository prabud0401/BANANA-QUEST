<?php
session_start();
require 'config.php';

$finalScore = $_SESSION['score'] ?? 0;
$username = $_SESSION['username'] ?? 'Player';

// Update player's score
$query = "UPDATE player_form 
          SET score = GREATEST(score, ?), games_played = games_played + 1 
          WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $finalScore, $username);
$stmt->execute();

// Update ranks
$conn->multi_query("SET @rank := 0;
                   UPDATE player_form
                   SET rank = (@rank := @rank + 1) 
                   ORDER BY score DESC;");
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banana Quest - Game Over</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        .jungle-split {
            background: linear-gradient(45deg, #1a2f1d 50%, #0f1a10 50%);
        }

        .share-card {
            background: linear-gradient(145deg, #142115, #1a2f1d);
            border: 3px solid #4d7c0f;
            box-shadow: 0 0 30px rgba(78, 124, 15, 0.3);
        }
    </style>
</head>
<body class="jungle-split min-h-screen">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Left Panel -->
        <div class="w-full md:w-1/2 bg-green-900/80 p-8 flex flex-col justify-center items-center text-center">
            <div class="max-w-2xl">
                <h1 class="text-5xl md:text-6xl font-black title-gradient mb-8">
                    <i class="ri-emotion-sad-line mr-3"></i>GAME OVER
                </h1>
                
                <div class="mb-8 animate-float">
                    <img src="https://file.aiquickdraw.com/imgcompressed/img/compressed_4fae4825289f642c84793a0b3596cc75.webp" 
                         class="w-48 mx-auto rounded-full border-4 border-yellow-400">
                </div>

                <div class="text-yellow-300 space-y-2">
                    <p class="text-xl">
                        <i class="ri-user-3-line mr-2"></i>
                        <?= htmlspecialchars($username) ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="w-full md:w-1/2 bg-green-950/90 p-8 flex flex-col justify-center">
            <div class="max-w-md mx-auto w-full space-y-6">
                <div class="share-card rounded-2xl p-8 text-center">
                    <h2 class="text-3xl font-bold text-yellow-400 mb-4">
                        Your Score: <?= number_format($finalScore) ?>
                    </h2>
                    
                    <!-- Social Sharing -->
                    <div class="mt-6">
                        <p class="text-yellow-300 mb-4">Share your achievement:</p>
                        <div class="flex justify-center gap-4">
                            <button onclick="shareTwitter()" 
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                <i class="ri-twitter-fill mr-2"></i>Twitter
                            </button>
                            <button onclick="shareFacebook()" 
                                    class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors">
                                <i class="ri-facebook-fill mr-2"></i>Facebook
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 space-y-4">
                    <form method="POST" action="menu.php">
                        <button class="menu-button w-full text-yellow-100 px-8 py-4 text-xl font-bold uppercase hover:scale-105 transition-transform">
                            <i class="ri-arrow-left-line mr-3"></i>Return to Base Camp
                        </button>
                    </form>
                    
                    <form method="POST" action="play_game.php">
                        <button class="menu-button w-full text-green-100 px-8 py-4 text-xl font-bold uppercase hover:scale-105 transition-transform">
                            <i class="ri-restart-line mr-3"></i>Try Again
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function shareTwitter() {
            const text = `I scored <?= number_format($finalScore) ?> points in Banana Quest! 🍌 Can you beat me?`;
            const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&hashtags=BananaQuest`;
            window.open(url, '_blank', 'width=600,height=400');
        }

        function shareFacebook() {
            const quote = `I scored <?= number_format($finalScore) ?> points in Banana Quest! 🍌 Can you beat me?`;
            const url = `https://www.facebook.com/sharer/sharer.php?quote=${encodeURIComponent(quote)}`;
            window.open(url, '_blank', 'width=600,height=400');
        }
    </script>
</body>
</html>