<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$lastVisit = date("Y-m-d H:i:s");

// Retrieve player information
$query = "SELECT username, score, rank, games_played, games_won FROM player_form WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BANANA QUEST - <?= htmlspecialchars($username) ?> Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        .profile-card {
            background: linear-gradient(145deg, #1a2f1d, #0f1a10);
            border: 3px solid #4d7c0f;
            box-shadow: 0 0 30px rgba(78, 124, 15, 0.3);
        }

        .stat-icon {
            background: linear-gradient(45deg, #facc15, #4d7c0f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="jungle-split min-h-screen">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Left Panel -->
        <div class="w-full md:w-1/2 bg-green-900/80 p-8 flex flex-col justify-center items-center text-center">
            <div class="max-w-2xl">
                <h1 class="text-5xl md:text-6xl font-black title-gradient mb-8">
                    <i class="ri-user-3-line mr-3"></i>PROFILE
                </h1>
                
                <div class="mb-8 animate-float">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
                         alt="Player Avatar" 
                         class="w-48 mx-auto rounded-full border-4 border-yellow-400">
                </div>

                <div class="text-yellow-300 space-y-2">
                    <p class="text-xl">
                        <i class="ri-time-fill mr-2"></i>
                        Last Active: <?= htmlspecialchars($lastVisit) ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="w-full md:w-1/2 bg-green-950/90 p-8 flex flex-col justify-center">
            <div class="max-w-md mx-auto w-full">
                <?php if ($result->num_rows > 0): 
                    $player = $result->fetch_assoc(); ?>
                    <div class="profile-card rounded-2xl p-8 space-y-6">
                        <div class="text-center">
                            <h2 class="text-3xl font-bold text-yellow-400 mb-2">
                                <?= htmlspecialchars($player['username']) ?>
                            </h2>
                            <p class="text-yellow-300/80">Banana Quest Champion</p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-green-900/50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <i class="ri-trophy-line stat-icon text-2xl"></i>
                                    <span class="text-yellow-200">Rank</span>
                                </div>
                                <span class="text-2xl font-bold text-yellow-400">#<?= htmlspecialchars($player['rank']) ?></span>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-green-900/50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <i class="ri-star-smile-line stat-icon text-2xl"></i>
                                    <span class="text-yellow-200">High Score</span>
                                </div>
                                <span class="text-2xl font-bold text-yellow-400"><?= htmlspecialchars($player['score']) ?></span>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 bg-green-900/50 rounded-lg text-center">
                                    <div class="text-yellow-400 font-bold text-2xl mb-1">
                                        <?= htmlspecialchars($player['games_played']) ?>
                                    </div>
                                    <div class="text-sm text-yellow-300/80">
                                        <i class="ri-gamepad-line"></i> Games Played
                                    </div>
                                </div>
                                
                                <div class="p-4 bg-green-900/50 rounded-lg text-center">
                                    <div class="text-yellow-400 font-bold text-2xl mb-1">
                                        <?= htmlspecialchars($player['games_won']) ?>
                                    </div>
                                    <div class="text-sm text-yellow-300/80">
                                        <i class="ri-medal-line"></i> Games Won
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="profile-card rounded-2xl p-8 text-center text-yellow-300">
                        <i class="ri-alert-line text-4xl mb-4"></i>
                        <p>No adventurer data found!</p>
                    </div>
                <?php endif; ?>

                <div class="mt-8">
                    <button onclick="window.location.href='menu.php'" 
                            class="menu-button w-full text-yellow-100 px-8 py-4 text-xl font-bold uppercase hover:scale-105 transition-transform">
                        <i class="ri-arrow-left-line mr-3"></i>Back to Banana Base
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>