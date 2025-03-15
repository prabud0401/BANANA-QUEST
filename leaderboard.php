<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Retrieve the top 10 players
$query = "SELECT username, score, rank FROM player_form ORDER BY score DESC LIMIT 10";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BANANA QUEST - Leaderboard</title>
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

        .leaderboard-card {
            background: linear-gradient(145deg, #142115, #1a2f1d);
            border: 3px solid #4d7c0f;
            box-shadow: 0 0 30px rgba(78, 124, 15, 0.3);
        }

        .rank-icon {
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
                    <i class="ri-trophy-line mr-3"></i>LEADERBOARD
                </h1>
                
                <div class="mb-8 animate-float">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
                         alt="Champion Monkey" 
                         class="w-48 mx-auto rounded-full border-4 border-yellow-400">
                </div>

                <div class="text-yellow-300 space-y-2">
                    <p class="text-xl">
                        <i class="ri-user-3-line mr-2"></i>
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="w-full md:w-1/2 bg-green-950/90 p-8 flex flex-col justify-center">
            <div class="max-w-md mx-auto w-full">
                <div class="leaderboard-card rounded-2xl p-8">
                    <?php if ($result->num_rows > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-yellow-400 border-b-2 border-green-700">
                                        <th class="pb-3 text-left"><i class="ri-medal-line"></i> Rank</th>
                                        <th class="pb-3 text-left"><i class="ri-user-line"></i> Player</th>
                                        <th class="pb-3 text-right"><i class="ri-star-line"></i> Score</th>
                                    </tr>
                                </thead>
                                <tbody class="text-yellow-300">
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr class="hover:bg-green-900/50 transition-colors">
                                        <td class="py-3">
                                            <?php switch($row['rank']) {
                                                case 1: echo '🥇'; break;
                                                case 2: echo '🥈'; break;
                                                case 3: echo '🥉'; break;
                                                default: echo '#' . $row['rank'];
                                            } ?>
                                        </td>
                                        <td class="py-3"><?= htmlspecialchars($row['username']) ?></td>
                                        <td class="py-3 text-right"><?= number_format($row['score']) ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8 text-yellow-300">
                            <i class="ri-alert-line text-4xl mb-4"></i>
                            <p>No champions yet!</p>
                        </div>
                    <?php endif; ?>
                </div>

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
$conn->close();
?>