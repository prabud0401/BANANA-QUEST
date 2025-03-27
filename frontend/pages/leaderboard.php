<div class="text-yellow-100 space-y-4">
            <h2 class="text-3xl font-bold text-yellow-400">
                <i class="ri-trophy-line mr-2"></i>Leaderboard
            </h2>
            <div id="leaderboardContent">
                <p>Loading leaderboard...</p>
            </div>
            <button onclick="fetchLeaderboard()"
                    class="game-button text-yellow-100 w-full px-8 py-4 mt-4 text-lg font-bold uppercase tracking-wider">
                <i class="ri-refresh-line mr-2"></i>Refresh
            </button>
        </div>

        <script>
            function fetchLeaderboard() {
                // AJAX call to backend function 'getLeaderboard'
                fetch('http://localhost/banana-quest/backend/functions.php?action=getLeaderboard')
                .then(response => response.json())
                .then(data => {
                    const leaderboard = document.getElementById('leaderboardContent');
                    leaderboard.innerHTML = data.map(entry => 
                        `<p>${entry.username}: ${entry.score}</p>`
                    ).join('');
                })
                .catch(error => console.error('Error fetching leaderboard:', error));
            }
            fetchLeaderboard(); // Load on page load
        </script>
