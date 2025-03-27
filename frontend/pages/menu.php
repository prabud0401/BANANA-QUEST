<!-- Animated Header -->
<div class="space-y-6 animate-pulse">
            <div class="flex items-center justify-center gap-4">
                <i class="ri-gamepad-fill text-5xl text-yellow-400 animate-spin-slow"></i>
                <h1 class="text-5xl md:text-6xl font-black bg-gradient-to-r from-yellow-400 to-green-400 bg-clip-text text-transparent">
                    BANANA QUEST
                </h1>
            </div>
            <p class="text-xl text-yellow-100 font-medium tracking-wide">
                Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Adventurer'); ?>!
            </p>
        </div>

        <!-- Menu Options -->
        <div class="flex flex-col gap-6 justify-center">
            <a href="?page=game" class="game-button text-yellow-100 px-10 py-5 text-xl font-bold uppercase tracking-wider">
                <i class="ri-play-fill mr-3"></i>Play Game
            </a>
            <a href="?page=leaderboard" class="game-button text-yellow-100 px-10 py-5 text-xl font-bold uppercase tracking-wider">
                <i class="ri-trophy-line mr-3"></i>Leaderboard
            </a>
            <a href="?page=profile" class="game-button text-yellow-100 px-10 py-5 text-xl font-bold uppercase tracking-wider">
                <i class="ri-user-line mr-3"></i>Profile
            </a>
            <a href="?page=logout" class="game-button text-yellow-100 px-10 py-5 text-xl font-bold uppercase tracking-wider">
                <i class="ri-logout-box-line mr-3"></i>Logout
            </a>
        </div>
