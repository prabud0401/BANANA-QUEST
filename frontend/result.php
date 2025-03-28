<?php
$page_title = "Result";
include 'header.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
?>
        <div class="space-y-6 animate-pulse">
            <div class="flex items-center justify-center gap-2 sm:gap-4">
                <i class="ri-star-line text-3xl sm:text-5xl md:text-6xl text-yellow-400 animate-spin-slow"></i>
                <h1 class="text-3xl sm:text-5xl md:text-7xl font-extrabold bg-gradient-to-r from-yellow-400 via-green-400 to-yellow-400 bg-clip-text text-transparent">GAME RESULT</h1>
            </div>
            <p class="text-base sm:text-xl md:text-2xl text-yellow-100 font-medium tracking-wide px-2"><span class="border-b-2 border-yellow-400">Your Score</span></p>
        </div>
        <div class="text-center text-yellow-400">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4">Game Over!</h2>
            <p class="text-lg sm:text-xl">Result details (e.g., score, rank) go here.</p>
            <a href="menu.php" class="game-button py-2 px-6 mt-6 inline-block text-white">Back to Menu</a>
        </div>
    </div>
</body>
</html>