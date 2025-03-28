<?php
$page_title = "Game";
include 'header.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
$username = $_SESSION['username'] ?? 'Monkey';
?>
<style>
    .profile-container {
        position: relative;
        background: #1a2e05;
    }
    .profile-container::before,
    .profile-container::after,
    .profile-container .extra-glow {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        pointer-events: none;
        z-index: -1;
    }
    .profile-container::before {
        background: radial-gradient(circle, rgba(250, 204, 21, 0.15) 0%, transparent 70%);
        animation: glow-rotate 12s linear infinite;
    }
    .profile-container::after {
        background: radial-gradient(circle, rgba(90, 158, 20, 0.1) 0%, transparent 60%);
        animation: glow-rotate 8s linear infinite reverse;
    }
    .profile-container .extra-glow {
        background: radial-gradient(circle, rgba(255, 140, 0, 0.12) 0%, transparent 50%);
        animation: glow-rotate 15s linear infinite;
    }
    @keyframes glow-rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .profile-box {
        background: rgba(58, 98, 19, 0.9);
        border: 2px solid #facc15;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(250, 204, 21, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .profile-box:hover {
        transform: scale(1.02);
        box-shadow: 0 12px 40px rgba(250, 204, 21, 0.5);
    }
    .monkey-float {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    @media (min-width: 768px) {
        .game-section, .profile-section {
            max-height: 100vh;
            width: 50%;
        }
    }
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .popup-content {
        background: rgba(58, 98, 19, 0.9);
        border: 2px solid #facc15;
        border-radius: 15px;
        padding: 1.5rem;
        max-width: 90%;
        width: 400px;
        text-align: center;
    }
    .difficulty-btn {
        background: linear-gradient(145deg, #5a9e14, #3b6213);
        border: 2px solid #facc15;
        border-radius: 10px;
        padding: 0.5rem 1rem;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .difficulty-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(250, 204, 21, 0.5);
    }
    .difficulty-btn.selected {
        background: linear-gradient(145deg, #facc15, #d4a017);
        border-color: #3b6213;
    }
    #gameCanvas {
        border: 2px solid #facc15;
        border-radius: 10px;
        background: #3b6213;
    }
</style>
<div class="w-full h-full flex flex-col md:flex-row justify-around items-center ">
    <span class="extra-glow"></span> <!-- Extra glow layer -->
    <!-- Left Side: Profile Area -->
    <div class="w-full md:w-1/2 flex flex-col items-center justify-between p-4 profile-section">
        <div class="profile-box w-full max-w-lg text-center space-y-4 p-4">
            <div class="space-y-6 animate-pulse">
                <div class="flex items-center justify-center gap-2 sm:gap-4">
                    <i class="ri-gamepad-fill text-3xl sm:text-5xl md:text-6xl text-yellow-400 animate-spin-slow"></i>
                    <h1 class="text-3xl sm:text-5xl md:text-7xl font-extrabold bg-gradient-to-r from-yellow-400 via-green-400 to-yellow-400 bg-clip-text text-transparent">BANANA QUEST</h1>
                </div>
                <p class="text-base sm:text-xl md:text-2xl text-yellow-100 font-medium tracking-wide px-2"><span class="border-b-2 border-yellow-400">Game Mode</span></p>
            </div>
            <img src="http://localhost/banana-quest/frontend/assets/images/logoN.png" alt="Monkey Icon" class="w-24 sm:w-40 md:w-64 lg:w-80 monkey-float cursor-pointer hover:scale-110 transition-transform mx-auto">
            <p class="text-base sm:text-xl text-yellow-100 font-medium tracking-wide"><span class="border-b-2 border-yellow-400"><?php echo htmlspecialchars($username); ?></span></p>
            <div class="text-yellow-400 space-y-2">
                <h2 class="text-2xl sm:text-3xl font-bold">Swing into Action!</h2>
                <p class="text-lg sm:text-xl">Collect bananas and dodge obstacles!</p>
            </div>
        </div>
        <a href="menu.php" class="game-button py-2 px-6 text-lg text-white flex items-center justify-center mt-4">
            <i class="ri-arrow-left-line mr-2"></i> Back to Menu
        </a>
    </div>
    <!-- Right Side: Game Play Area -->
    <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-4 game-section">
        <div class="w-full max-w-2xl text-center space-y-4 p-4">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-yellow-400 mb-4">Banana Quest - Level <span id="levelDisplay">1</span></h2>
            <div id="bananaCounter" class="flex justify-center gap-2 mb-4">
                <img src="https://cdn-icons-png.flaticon.com/512/1998/1998721.png" alt="Banana" class="w-8 h-8">
                <img src="https://cdn-icons-png.flaticon.com/512/1998/1998721.png" alt="Banana" class="w-8 h-8">
                <img src="https://cdn-icons-png.flaticon.com/512/1998/1998721.png" alt="Banana" class="w-8 h-8">
            </div>
            <canvas id="gameCanvas" width="600" height="400"></canvas>
        </div>
    </div>
    <!-- Difficulty Selection Modal -->
    <div id="difficultyModal" class="popup" style="display: flex;">
        <div class="popup-content">
            <h2 class="text-2xl font-bold text-yellow-400 mb-4">Choose Difficulty</h2>
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-4">
                <button class="difficulty-btn" data-difficulty="Easy">Easy</button>
                <button class="difficulty-btn selected" data-difficulty="Medium">Medium</button>
                <button class="difficulty-btn" data-difficulty="Hard">Hard</button>
            </div>
            <button id="startGameBtn" class="game-button py-2 px-6 text-white w-full">Start Game</button>
        </div>
    </div>
    <!-- Next Level Modal -->
    <div id="nextLevelModal" class="popup">
        <div class="popup-content">
            <h2 class="text-2xl font-bold text-yellow-400 mb-4">Level Complete!</h2>
            <p class="text-lg text-white mb-4">Proceed to Level <span id="nextLevelDisplay">2</span>?</p>
            <button id="nextLevelBtn" class="game-button py-2 px-6 text-white w-full">Next Level</button>
            <button id="exitLevelBtn" class="mt-4 text-yellow-400 hover:text-yellow-300">Exit</button>
        </div>
    </div>
</div>
</body>

</html>