<div class="text-yellow-100 space-y-4">
            <h2 class="text-3xl font-bold text-yellow-400">
                <i class="ri-user-line mr-2"></i>Profile
            </h2>
            <p>Username: <?php echo htmlspecialchars($_SESSION['username'] ?? 'Unknown'); ?></p>
            <p>Level: <span id="playerLevel"><?php echo $_SESSION['level'] ?? 1; ?></span></p>
            <p>Score: <span id="playerScore"><?php echo $_SESSION['score'] ?? 0; ?></span></p>
            <button onclick="fetchProfile()"
                    class="game-button text-yellow-100 w-full px-8 py-4 mt-4 text-lg font-bold uppercase tracking-wider">
                <i class="ri-refresh-line mr-2"></i>Refresh
            </button>
        </div>

        <script>
            function fetchProfile() {
                // AJAX call to backend function 'getProfile'
                fetch('http://localhost/banana-quest/backend/functions.php?action=getProfile')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('playerLevel').textContent = data.level;
                    document.getElementById('playerScore').textContent = data.score;
                })
                .catch(error => console.error('Error fetching profile:', error));
            }
        </script>
