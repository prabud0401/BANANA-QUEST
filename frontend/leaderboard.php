<?php
$page_title = "Leaderboard";
include 'header.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
$username = $_SESSION['username'] ?? 'Monkey';
?>
<link href="http://localhost/banana-quest/frontend/assets/css/leaderboard.css" rel="stylesheet">

<div class="w-full h-full flex flex-col md:flex-row justify-around items-center md:spce-y-0 space-y-6">
    <!-- Current User Position (Top on Mobile, Left on Desktop) -->
    <div class="space-y-6 md:order-1 order-1 text-center w-full flex flex-col justify-center items-center flex-shrink-0 current-user-section">
        <div class="flex items-center justify-center gap-2 sm:gap-4 animate-pulse">
            <i class="ri-trophy-line text-3xl sm:text-5xl md:text-6xl text-yellow-400 animate-spin-slow"></i>
            <h1 class="text-3xl sm:text-5xl md:text-7xl font-extrabold bg-gradient-to-r from-yellow-400 via-green-400 to-yellow-400 bg-clip-text text-transparent">LEADERBOARD</h1>
        </div>
        <p class="text-base sm:text-xl md:text-2xl text-yellow-100 font-medium tracking-wide px-2"><span class="border-b-2 border-yellow-400">Top Banana Collectors</span></p>
        <div class="current-user w-full md:w-3/4 relative">
            <svg class="absolute top-2 right-2 w-12 h-12 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm0 2c-4.41 0-8 3.59-8 8s3.59 8 8 8 8-3.59 8-8-3.59-8-8-8zm-1 2h2v6h-2V6zm0 8h2v2h-2v-2z"/></svg>
            <img src="http://localhost/banana-quest/frontend/assets/images/logoN.png" alt="Monkey Icon" class="w-24 sm:w-40 md:w-64 lg:w-80 monkey-float cursor-pointer hover:scale-110 transition-transform mx-auto">
            <h2 class="text-xl sm:text-xl md:text-2xl font-bold text-yellow-400 mb-4"><?php echo htmlspecialchars($username); ?></h2>
            <p class="text-xl sm:text-2xl md:text-3xl text-white">Position: <span id="currentPosition">-</span></p>
            <p class="text-lg sm:text-xl md:text-2xl text-white flex items-center justify-center gap-2">
                Score: <span id="currentScore">-</span>
                <svg class="w-6 h-6 text-yellow-400 banana-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm-1 4h2v6h-2V6zm0 8h2v2h-2v-2z"/></svg>
            </p>
        </div>
    </div>
    <!-- Leaderboard List (Bottom on Mobile, Right on Desktop) -->
    <div class="flex flex-col gap-6 justify-center items-center w-full md:order-2 order-2 text-center leaderboard-section">
        <div id="leaderboardList" class="w-full md:w-3/4 space-y-4">
            <!-- Top 10 leaderboard entries will be populated here via AJAX -->
        </div>
        <a href="menu.php" class="game-button w-full md:max-w-72 py-6 md:px-6 md:py-4 text-xl sm:text-2xl md:text-lg font-bold uppercase tracking-widest flex-shrink-0">
            <i class="ri-arrow-left-line mr-4"></i>Back to Menu
        </a>
    </div>
</div>

<?php include 'http://localhost/banana-quest/frontend/footer.php'; ?>

<script>
    // Fetch leaderboard data via AJAX
    fetch('http://localhost/banana-quest/backend/fetch_users_data.php')
        .then(response => response.json())
        .then(data => {
            const leaderboardList = document.getElementById('leaderboardList');
            const currentPosition = document.getElementById('currentPosition');
            const currentScore = document.getElementById('currentScore');
            const currentUser = '<?php echo htmlspecialchars($username); ?>';

            // Sort users by total score and take top 10
            const sortedUsers = data.sort((a, b) => b.score - a.score);
            const top10Users = sortedUsers.slice(0, 10);

            // Populate leaderboard with top 10 only
            leaderboardList.innerHTML = top10Users.map((user, index) => {
                let rankIcon = '';
                if (index === 0) rankIcon = '<i class="ri-crown-line text-yellow-400 mr-2"></i>';
                else if (index === 1) rankIcon = '<i class="ri-medal-line text-yellow-400 mr-2"></i>';
                else if (index === 2) rankIcon = '<i class="ri-medal-line text-yellow-400 mr-2"></i>';
                else rankIcon = `#${index + 1}`;
                return `
                    <div class="leaderboard-entry">
                        <p class="text-lg sm:text-xl md:text-2xl text-yellow-400 font-bold flex items-center">${rankIcon} ${user.username}</p>
                        <p class="text-base sm:text-lg md:text-xl text-white flex items-center gap-2">
                            ${user.score}
                            <svg class="w-5 h-5 text-yellow-400 banana-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm-1 4h2v6h-2V6zm0 8h2v2h-2v-2z"/></svg>
                        </p>
                    </div>
                `;
            }).join('');

            // Find and display current user's position and score
            const currentUserData = sortedUsers.find(user => user.username === currentUser);
            if (currentUserData) {
                const position = sortedUsers.indexOf(currentUserData) + 1;
                currentPosition.textContent = position;
                currentScore.textContent = currentUserData.score;
            } else {
                currentPosition.textContent = 'N/A';
                currentScore.textContent = '0';
            }
        })
        .catch(error => {
            console.error('Error fetching leaderboard:', error);
            document.getElementById('leaderboardList').innerHTML = '<p class="text-red-400">Failed to load leaderboard.</p>';
        });
</script>
