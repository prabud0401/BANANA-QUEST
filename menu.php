<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Handle level selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['level'])) {
    $_SESSION['level'] = $_POST['level'];
    header("Location: play_game.php");
    exit();
}

$username = $_SESSION['username'];
$lastVisit = date("Y-m-d H:i:s");
setcookie("last_visit", $lastVisit, time() + (86400 * 30), "/");
$displayVisitMessage = isset($_COOKIE['last_visit']) ? $_COOKIE['last_visit'] : $lastVisit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BANANA QUEST - <?= htmlspecialchars($username) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        @keyframes modalEnter {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .jungle-split {
            background: linear-gradient(45deg, #1a2f1d 50%, #0f1a10 50%);
        }

        .title-gradient {
            background: linear-gradient(45deg, #facc15, #4d7c0f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .menu-button {
            background: linear-gradient(145deg, #2d4a32, #1a2f1d);
            border: 3px solid #4d7c0f;
            transition: all 0.3s ease;
        }

        .level-modal {
            background: linear-gradient(145deg, #142115, #1a2f1d);
            border: 3px solid #facc15;
            box-shadow: 0 0 40px rgba(250, 204, 21, 0.2);
        }

        .level-button {
            background: linear-gradient(145deg, #2d4a32, #1a2f1d);
            border: 2px solid #4d7c0f;
            transition: all 0.3s ease;
        }

        .level-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(250, 204, 21, 0.2);
        }
    </style>
</head>
<body class="jungle-split min-h-screen">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Left Panel -->
        <div class="w-full md:w-1/2 bg-green-900/80 p-8 flex flex-col justify-center items-center text-center">
            <div class="max-w-2xl">
                <h1 class="text-5xl md:text-7xl font-black title-gradient mb-6">
                    BANANA QUEST
                </h1>
                
                <div class="monkey-float mb-8">
                    <img src="https://static.vecteezy.com/system/resources/previews/052/243/093/non_2x/adorable-monkey-holding-banana-clipart-for-craft-projects-free-png.png" 
                         alt="Monkey King" 
                         class="w-48 md:w-64 mx-auto animate-float">
                </div>

                <div class="text-yellow-300 space-y-4">
                    <p class="text-xl">
                        <i class="ri-user-3-fill mr-2"></i>
                        <?= htmlspecialchars($username) ?>
                    </p>
                    <p class="text-sm text-yellow-400/80">
                        <i class="ri-time-fill mr-2"></i>
                        <?= isset($_COOKIE['last_visit']) ? 
                            "Last visit: ".$_COOKIE['last_visit'] : 
                            "First adventure!" ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="w-full md:w-1/2 bg-green-950/90 p-8 flex flex-col justify-center">
            <div class="max-w-md mx-auto space-y-6 w-full">
                <button onclick="showLevelModal()" 
                        class="menu-button w-full text-yellow-100 px-8 py-4 text-xl font-bold uppercase">
                    <i class="ri-gamepad-line mr-3"></i>Start Quest
                </button>

                <form method="POST" action="leaderboard.php">
                    <button class="menu-button w-full text-yellow-100 px-8 py-4 text-xl font-bold uppercase">
                        <i class="ri-bar-chart-line mr-3"></i>Leaderboard
                    </button>
                </form>

                <form method="POST" action="my_profile.php">
                    <button class="menu-button w-full text-yellow-100 px-8 py-4 text-xl font-bold uppercase">
                        <i class="ri-user-settings-line mr-3"></i>My Profile
                    </button>
                </form>

                <form method="POST" action="logout.php">
                    <button class="menu-button w-full text-red-300 px-8 py-4 text-xl font-bold uppercase hover:text-red-100">
                        <i class="ri-logout-box-r-line mr-3"></i>Exit Quest
                    </button>
                </form>
            </div>
        </div>

        <!-- Level Select Modal -->
        <div id="levelModal" class="fixed inset-0 bg-black/90 hidden backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="level-modal rounded-xl p-8 max-w-md w-full animate-modalEnter">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-yellow-400">
                        <i class="ri-dashboard-line mr-2"></i>Select Difficulty
                    </h2>
                    <button onclick="hideLevelModal()" class="text-yellow-400 hover:text-yellow-200">
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>

                <form method="POST" class="space-y-4">
                    <button type="submit" name="level" value="easy" 
                            class="level-button w-full text-green-400 px-8 py-4 text-lg font-bold uppercase">
                        <i class="ri-leaf-line mr-2"></i>Easy Jungle
                    </button>

                    <button type="submit" name="level" value="medium" 
                            class="level-button w-full text-yellow-400 px-8 py-4 text-lg font-bold uppercase">
                        <i class="ri-flashlight-line mr-2"></i>Medium Forest
                    </button>

                    <button type="submit" name="level" value="hard" 
                            class="level-button w-full text-red-400 px-8 py-4 text-lg font-bold uppercase">
                        <i class="ri-fire-line mr-2"></i>Hard Volcano
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showLevelModal() {
            document.getElementById('levelModal').classList.remove('hidden');
        }

        function hideLevelModal() {
            document.getElementById('levelModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.id === 'levelModal') {
                hideLevelModal();
            }
        }
    </script>
</body>
</html>