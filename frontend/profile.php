<?php
$page_title = "Profile";
include 'header.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
$username = $_SESSION['username'] ?? 'Monkey';
?>
<style>
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
    .history-section, .profile-section {
        overflow-y: auto;
    }
    #historyTable {
        border-collapse: collapse;
        background: rgba(58, 98, 19, 0.9);
        border: 2px solid #facc15;
        border-radius: 10px;
        overflow: hidden;
    }
    #historyTable th, #historyTable td {
        padding: 0.75rem 1rem;
        white-space: nowrap; /* Prevents text wrapping */
        overflow: hidden;
        text-overflow: ellipsis; /* Adds "..." if text is truncated */
    }
    #historyTable thead tr {
        background: #3b6213;
        border-bottom: 2px solid #facc15;
    }
    #historyTable tbody tr {
        border-bottom: 1px solid #facc15;
    }
    #historyTable tbody tr:last-child {
        border-bottom: none;
    }
    #historyTable tbody tr:hover {
        background: rgba(90, 158, 20, 0.8);
    }
    @media (min-width: 768px) {
        .history-section, .profile-section {
            max-height: 100vh;
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
</style>
<div class="w-full h-full flex flex-col md:flex-row justify-around items-center ">
    <span class="extra-glow"></span> <!-- Extra glow layer -->

    <!-- Right Side: Profile Details -->
    <div class="w-full flex flex-col items-center justify-between profile-section">
        <div class="profile-box w-full max-w-lg text-center space-y-4 p-4">
            <div class="flex items-center justify-center gap-2 sm:gap-4 animate-pulse">
                <i class="ri-user-line text-3xl sm:text-5xl text-yellow-400 animate-spin-slow"></i>
                <h1 class="text-3xl sm:text-5xl font-extrabold bg-gradient-to-r from-yellow-400 via-green-400 to-yellow-400 bg-clip-text text-transparent">PROFILE</h1>
            </div>
            <img src="http://localhost/banana-quest/frontend/assets/images/logoN.png" alt="Monkey Icon" class="w-24 sm:w-40 md:w-64 lg:w-80 monkey-float cursor-pointer hover:scale-110 transition-transform mx-auto">
            <p class="text-base sm:text-xl text-yellow-100 font-medium tracking-wide"><span class="border-b-2 border-yellow-400"><?php echo htmlspecialchars($username); ?></span></p>
            <div class="text-white space-y-2">
                <p class="text-lg sm:text-xl">Highest Score: <span id="totalScore">-</span></p>
                <p class="text-lg sm:text-xl">Games Played: <span id="gamesPlayed">-</span></p>
            </div>
            <button id="updatePasswordBtn" class="game-button py-2 px-6 text-lg text-white mt-4">Update Password</button>
        </div>
        <a href="menu.php" class="game-button py-2 px-6 text-lg text-white flex items-center justify-center mt-4">
            <i class="ri-arrow-left-line mr-2"></i> Back to Menu
        </a>
    </div>
    <!-- Left Side: History -->
    <div class="w-full flex flex-col items-center history-section overflow-y-auto">
        <div class="w-full max-w-2xl flex flex-col items-center">
            <h2 class="text-xl sm:text-2xl font-bold text-yellow-400 mb-4">Game History</h2>
            <button id="clearHistoryBtn" class="game-button py-2 px-6 text-lg text-white mb-4">Clear History</button>
            <div class="w-full overflow-x-auto">
                <table id="historyTable" class="w-full text-left text-white">
                    <thead>
                        <tr>
                            <th class="text-yellow-400">Action</th>
                            <th class="text-yellow-400">Score</th>
                            <th class="text-yellow-400">Details</th>
                            <th class="text-yellow-400">Date</th>
                        </tr>
                    </thead>
                    <tbody id="historyBody">
                        <!-- Populated via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Password Update Modal -->
    <div id="updateModal" class="popup">
        <div class="popup-content">
            <h2 class="text-2xl font-bold text-yellow-400 mb-4">Update Password</h2>
            <form id="updatePasswordForm" class="space-y-4">
                <input type="password" name="current_password" placeholder="Current Banana Code" class="w-full p-2 rounded border border-yellow-400 bg-green-800 text-white" required>
                <input type="password" name="new_password" placeholder="New Banana Code" class="w-full p-2 rounded border border-yellow-400 bg-green-800 text-white" required>
                <input type="password" name="confirm_password" placeholder="Repeat New Banana Code" class="w-full p-2 rounded border border-yellow-400 bg-green-800 text-white" required>
                <button type="submit" class="game-button py-2 px-6 text-white w-full">Update</button>
            </form>
            <div id="modalMessage" class="text-white mt-4"></div>
            <div id="modalLoading" class="loading mt-4 hidden"><i class="ri-loader-4-line text-4xl text-yellow-400"></i></div>
            <button id="closeModal" class="mt-4 text-yellow-400 hover:text-yellow-300">Close</button>
        </div>
    </div>
</div>

<script>
    // Fetch user history via AJAX
    function fetchHistory() {
        fetch('http://localhost/banana-quest/backend/fetch_user_history.php')
            .then(response => response.json())
            .then(data => {
                const historyBody = document.getElementById('historyBody');
                const totalScoreSpan = document.getElementById('totalScore');
                const gamesPlayedSpan = document.getElementById('gamesPlayed');
                
                if (data.length === 0) {
                    historyBody.innerHTML = '<tr><td colspan="4" class="p-2 text-yellow-100">No history yet!</td></tr>';
                    totalScoreSpan.textContent = '0';
                    gamesPlayedSpan.textContent = '0';
                } else {
                    historyBody.innerHTML = data.map(entry => `
                        <tr class="border-b border-green-700">
                            <td class="p-2 text-yellow-400">${entry.action}</td>
                            <td class="p-2">${entry.score}</td>
                            <td class="p-2">${entry.details || '-'}</td>
                            <td class="p-2">${entry.timestamp}</td>
                        </tr>
                    `).join('');
                    const highestScore = Math.max(...data.map(entry => parseInt(entry.score)));
                    const gamesPlayed = data.length;
                    totalScoreSpan.textContent = highestScore;
                    gamesPlayedSpan.textContent = gamesPlayed;
                }
            })
            .catch(error => {
                console.error('Error fetching history:', error);
                document.getElementById('historyBody').innerHTML = '<tr><td colspan="4" class="p-2 text-red-400">Failed to load history.</td></tr>';
            });
    }
    fetchHistory();

    // Clear history via AJAX
    const clearHistoryBtn = document.getElementById('clearHistoryBtn');
    clearHistoryBtn.addEventListener('click', async () => {
        if (!confirm('Are you sure you want to clear your history?')) return;

        try {
            const response = await fetch('http://localhost/banana-quest/backend/clear_user_history.php', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            if (data.status === 'success') {
                location.reload(); // Refresh page on success
            } else {
                alert('Failed to clear history: ' + (data.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error clearing history:', error);
            alert('Jungle Network Trouble!');
        }
    });

    // Password update modal handling
    const updateBtn = document.getElementById('updatePasswordBtn');
    const updateModal = document.getElementById('updateModal');
    const updateForm = document.getElementById('updatePasswordForm');
    const modalMessage = document.getElementById('modalMessage');
    const modalLoading = document.getElementById('modalLoading');
    const closeModal = document.getElementById('closeModal');

    updateBtn.addEventListener('click', () => {
        updateModal.style.display = 'flex';
    });

    updateForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const newPassword = formData.get('new_password');
        const confirmPassword = formData.get('confirm_password');

        if (newPassword !== confirmPassword) {
            modalMessage.textContent = 'New Banana Codes don\'t match!';
            modalLoading.style.display = 'none';
            return;
        }

        modalMessage.textContent = 'Updating your password...';
        modalLoading.style.display = 'block';

        try {
            const response = await fetch('http://localhost/banana-quest/backend/update_password.php', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            modalLoading.style.display = 'none';
            modalMessage.textContent = data.message || (data.status === 'success' ? 'Password updated successfully!' : 'Oops, something went wrong.');
            modalMessage.style.color = data.status === 'success' ? '#facc15' : '#ff4444';
            if (data.status === 'success') {
                setTimeout(() => {
                    updateModal.style.display = 'none';
                    updateForm.reset();
                    modalMessage.textContent = '';
                }, 2000);
            }
        } catch (error) {
            modalLoading.style.display = 'none';
            modalMessage.textContent = 'Jungle Network Trouble!';
            modalMessage.style.color = '#ff4444';
            console.error('Error updating password:', error);
        }
    });

    closeModal.addEventListener('click', () => {
        updateModal.style.display = 'none';
        modalMessage.textContent = '';
        modalLoading.style.display = 'none';
    });
</script>
