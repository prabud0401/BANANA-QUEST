<?php
// play_game.php
session_start();
require 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Initialize game state
if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = [
        'walls' => 2,
        'current_position' => 0,
        'round' => 1,
        'lives' => 3,
        'score' => 0,
        'question' => '',
        'solution' => ''
    ];
}

// Handle game actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['answer'])) {
        // Validate answer
        if ((int)$_POST['answer'] === (int)$_SESSION['game']['solution']) {
            $_SESSION['game']['current_position']++;
            $_SESSION['game']['score'] += 100;
            
            // Check round completion
            if ($_SESSION['game']['current_position'] >= $_SESSION['game']['walls']) {
                $_SESSION['game']['round']++;
                $_SESSION['game']['walls'] += 2;
                $_SESSION['game']['current_position'] = 0;
                $_SESSION['game']['score'] += 500;
            }
            
            // Force new puzzle
            unset($_SESSION['game']['question']);
            unset($_SESSION['game']['solution']);
        } else {
            $_SESSION['game']['lives']--;
            if ($_SESSION['game']['lives'] <= 0) {
                header("Location: game_over.php");
                exit();
            }
        }
    }
    
    if (isset($_POST['restart'])) {
        session_unset();
        header("Location: play_game.php");
        exit();
    }

    // End Game handler
    if (isset($_POST['end_game'])) {
        header("Location: game_over.php");
        exit();
    }
}

// Fetch new puzzle if needed
if (empty($_SESSION['game']['question'])) {
    $apiUrl = "https://marcconrad.com/uob/banana/api.php?out=json";
    try {
        $response = file_get_contents($apiUrl);
        if ($response === false) {
            throw new Exception('Failed to fetch puzzle from API');
        }
        
        $data = json_decode($response, true);
        if (!isset($data['question']) || !isset($data['solution'])) {
            throw new Exception('Invalid API response');
        }
        
        $_SESSION['game']['question'] = $data['question'];
        $_SESSION['game']['solution'] = $data['solution'];
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banana Temple Quest - Round <?= $_SESSION['game']['round'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .temple-wall {
            background: url('https://img.freepik.com/premium-photo/old-stone-wall-texture-background_118047-1095.jpg');
            border: 4px solid #5a4d42;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .temple-door {
            background: url('https://static.vecteezy.com/system/resources/previews/010/180/886/non_2x/old-wooden-door-on-white-background-vector.jpg');
            background-size: cover;
            border: 3px solid #3a2f25;
            transition: all 0.3s ease;
        }

        .safe-area {
            background: url('https://t3.ftcdn.net/jpg/05/65/56/64/360_F_565566436_N3H1HhZ6LvxUsQhopHcTYs14cWz0vD3n.jpg');
            background-size: cover;
        }

        .monkey {
            transition: all 0.5s ease-in-out;
            filter: drop-shadow(0 5px 3px rgba(0,0,0,0.3));
        }
    </style>
</head>
<body class="bg-stone-800">
    <div class="relative min-h-screen overflow-hidden">
        <!-- Top Bananas -->
        <div class="absolute top-0 w-full flex justify-center py-4 animate-float z-10">
            <?php for ($i = 0; $i < 10; $i++): ?>
                <img src="https://static.vecteezy.com/system/resources/previews/001/208/650/non_2x/banana-png.png" 
                     class="w-12 h-12 -rotate-45 mx-1">
            <?php endfor; ?>
        </div>

        <!-- Game Area -->
        <div class="container mx-auto px-4 py-8 relative z-20">
            <!-- Stats Bar -->
            <div class="flex justify-between items-center mb-6 p-4 bg-stone-700/80 rounded-lg">
                <div class="text-yellow-400">
                    <span class="text-xl font-bold">🏆 <?= $_SESSION['game']['score'] ?></span>
                    <span class="mx-4">❤️ <?= $_SESSION['game']['lives'] ?></span>
                    <span class="text-sm">Round <?= $_SESSION['game']['round'] ?></span>
                </div>
                <div class="flex gap-4">
                    <form method="POST">
                        <button name="end_game" 
                                class="text-yellow-400 hover:text-yellow-200 transition-colors"
                                title="End Game">
                            <i class="ri-shut-down-line text-2xl"></i>
                        </button>
                    </form>
                    <button onclick="showHelp()" 
                            class="text-yellow-400 hover:text-yellow-200">
                        <i class="ri-information-line text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Temple Structure -->
            <div class="relative temple-structure" style="height: 70vh; margin: 0 auto; width: 300px;">
                <?php for ($i = 0; $i < $_SESSION['game']['walls']; $i++): ?>
                    <!-- Safe Area -->
                    <div class="safe-area h-16 mb-2 rounded"></div>
                    
                    <!-- Wall with Door -->
                    <div class="temple-wall h-24 mb-2 rounded-lg flex items-center justify-center">
                        <div class="temple-door w-20 h-20 rounded-lg cursor-pointer"
                             data-position="<?= $i ?>"
                             onclick="showPuzzleModal(this)"></div>
                    </div>
                <?php endfor; ?>
                
                <!-- Monkey -->
                <img src="https://file.aiquickdraw.com/imgcompressed/img/compressed_4fae4825289f642c84793a0b3596cc75.webp" 
                     class="monkey absolute bottom-0 left-1/2 -translate-x-1/2 w-20 h-20"
                     style="transform: translateY(<?= -$_SESSION['game']['current_position'] * 160 ?>px)">
            </div>
        </div>

        <!-- Puzzle Modal -->
        <div id="puzzleModal" class="fixed inset-0 bg-stone-900/90 hidden backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-stone-700/90 rounded-xl p-8 max-w-md w-full border-2 border-stone-600">
                <h2 class="text-2xl font-bold text-yellow-400 mb-4">Solve the Puzzle!</h2>
                <img src="<?= htmlspecialchars($_SESSION['game']['question']) ?>" 
                     class="w-full mb-4 rounded-lg border-2 border-stone-600"
                     alt="Math Puzzle">
                <form method="POST" class="flex gap-4">
                    <input type="number" name="answer" 
                           class="flex-1 bg-stone-800 text-yellow-100 px-4 py-2 rounded-lg"
                           placeholder="Enter answer" 
                           required
                           autofocus>
                    <button type="submit" 
                            class="bg-yellow-400 text-stone-900 px-6 py-2 rounded-lg font-bold hover:bg-yellow-300">
                        Submit
                    </button>
                </form>
            </div>
        </div>

        <!-- Game State Modals -->
        <div id="gameOverModal" class="fixed inset-0 bg-stone-900/90 hidden backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-stone-700/90 rounded-xl p-8 max-w-md w-full border-2 border-stone-600 text-center">
                <h2 class="text-3xl font-bold text-red-400 mb-4">Game Over!</h2>
                <p class="text-yellow-300 mb-6">Final Score: <?= $_SESSION['game']['score'] ?></p>
                <form method="POST">
                    <button name="restart" 
                            class="bg-yellow-400 text-stone-900 px-6 py-2 rounded-lg font-bold hover:bg-yellow-300">
                        Play Again
                    </button>
                </form>
            </div>
        </div>

        <div id="roundCompleteModal" class="fixed inset-0 bg-stone-900/90 <?= $_SESSION['game']['current_position'] >= $_SESSION['game']['walls'] ? '' : 'hidden' ?> backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-stone-700/90 rounded-xl p-8 max-w-md w-full border-2 border-stone-600 text-center">
                <h2 class="text-3xl font-bold text-green-400 mb-4">Round Complete!</h2>
                <p class="text-yellow-300 mb-6">Bonus +500 Points!</p>
                <button onclick="location.reload()" 
                        class="bg-yellow-400 text-stone-900 px-6 py-2 rounded-lg font-bold hover:bg-yellow-300">
                    Continue
                </button>
            </div>
        </div>
    </div>

    <script>
        function showPuzzleModal(door) {
            const position = parseInt(door.dataset.position);
            if (position === <?= $_SESSION['game']['current_position'] ?>) {
                document.getElementById('puzzleModal').classList.remove('hidden');
            }
        }

        // Auto-show modals
        window.onload = () => {
            <?php if ($_SESSION['game']['lives'] <= 0): ?>
                document.getElementById('gameOverModal').classList.remove('hidden');
            <?php endif; ?>
            
            // Close puzzle modal after submission
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                document.getElementById('puzzleModal').classList.add('hidden');
            <?php endif; ?>
        }

        // Close modals on outside click
        window.onclick = function(event) {
            const modals = ['puzzleModal', 'gameOverModal'];
            if (modals.includes(event.target.id)) {
                event.target.classList.add('hidden');
            }
        }
    </script>
</body>
</html>