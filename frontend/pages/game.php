<div class="text-yellow-100 space-y-4">
            <h2 class="text-3xl font-bold text-yellow-400">
                <i class="ri-gamepad-line mr-2"></i>Banana Quest - Level 1
            </h2>
            <p>Score: <span id="playerScore">0</span></p>
            <p>Puzzle: Find the hidden banana in the jungle!</p>
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-green-900 p-4 rounded-lg">?</div>
                <div class="bg-green-900 p-4 rounded-lg">?</div>
                <div class="bg-green-900 p-4 rounded-lg">?</div>
                <div class="bg-green-900 p-4 rounded-lg">?</div>
            </div>
            <button onclick="fetchGameData()"
                    class="game-button text-yellow-100 px-8 py-4 text-lg font-bold uppercase tracking-wider">
                <i class="ri-refresh-line mr-2"></i>Next Puzzle
            </button>
        </div>

        <script>
            function fetchGameData() {
                // AJAX call to backend function 'getGameData'
                fetch('http://localhost/banana-quest/backend/functions.php?action=getGameData')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('playerScore').textContent = data.score;
                    // Update game content dynamically here
                })
                .catch(error => console.error('Error fetching game data:', error));
            }
        </script>
