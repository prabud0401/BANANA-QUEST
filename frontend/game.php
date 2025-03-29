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
            z-index: 3000;
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
        .canvas-container {
            width: 100%;
            height: 400px;
            overflow-y: auto;
            border: 2px solid #facc15;
            border-radius: 10px;
            background: #3b6213;
            position: relative;
            transition: all 1s ease-in-out;
        }
        .canvas-container.fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            border-radius: 0;
            z-index: 2000;
        }
        #expandBtn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 2500;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 2rem;
            color: yellow;
        }
        #overlayInfo {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2600;
            color: yellow;
            font-size: 1.2rem;
            background: rgba(0, 0, 0, 0.4);
            padding: 5px 10px;
            border-radius: 5px;
        }
        .game-info {
            background: rgba(58, 98, 19, 0.9);
            border: 2px solid #facc15;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            margin-bottom: 1rem;
        }
        
        /* Make the feedback images responsive (especially for mobile) */
        .feedback-image {
            width: 100%;
            max-width: 300px;
            margin: 0 auto 1rem auto;
            display: block;
        }
    </style>

<div class="w-full h-full flex flex-col md:flex-row justify-around items-center">
    <span class="extra-glow"></span>
    <!-- Left Side: Profile Area -->
    <div class="w-full md:w-1/2 flex flex-col items-center justify-between profile-section">
        <div class="profile-box w-full max-w-lg text-center space-y-4 p-4">
            <div class="space-y-6 animate-pulse">
                <div class="flex items-center justify-center gap-2 sm:gap-4">
                    <i class="ri-gamepad-fill text-3xl sm:text-5xl md:text-6xl text-yellow-400 animate-spin-slow"></i>
                    <h1 class="text-3xl sm:text-5xl font-extrabold bg-gradient-to-r from-yellow-400 via-green-400 to-yellow-400 bg-clip-text text-transparent">
                        BANANA QUEST
                    </h1>
                </div>
                <p class="md:inline hidden text-base sm:text-xl md:text-2xl text-yellow-100 font-medium tracking-wide px-2">
                    <span class="border-b-2 border-yellow-400">Game Mode</span>
                </p>
            </div>
            <img src="http://localhost/banana-quest/frontend/assets/images/logoN.png"
                 alt="Monkey Icon"
                 class="w-24 sm:w-40 md:w-64 lg:w-80 monkey-float cursor-pointer hover:scale-110 transition-transform mx-auto">
            <p class="text-base sm:text-xl text-yellow-100 font-medium tracking-wide">
                <span class="border-b-2 border-yellow-400"><?php echo htmlspecialchars($username); ?></span>
            </p>
            <div class="md:inline hidden text-yellow-400 space-y-2">
                <h2 class="text-2xl sm:text-3xl font-bold">Swing into Action!</h2>
                <p class="text-lg sm:text-xl">Get ready to play!</p>
            </div>
        </div>
        <a href="menu.php" class="game-button py-2 px-6 text-lg text-white flex items-center justify-center mt-4">
            <i class="ri-arrow-left-line mr-2"></i> Back to Menu
        </a>
    </div>
    <!-- Right Side: Game Display Area -->
    <div class="w-full md:w-1/2 flex flex-col items-center justify-center game-section">
        <div class="w-full max-w-2xl text-center space-y-4 p-4">
            <!-- Normal score and level display -->
            <div class="game-info flex justify-between text-yellow-400 font-bold text-lg">
                <span>Score: <span id="scoreDisplay">0</span></span>
                <span>Level: <span id="levelDisplay">1</span></span>
            </div>
            <div id="bananaCounter" class="hidden text-yellow-400 font-bold text-lg mb-4">Bananas: 3</div>
            <div class="canvas-container" id="canvasContainer">
                <!-- Expand button -->
                <button id="expandBtn">
                    <i class="ri-fullscreen-line"></i>
                </button>
                <!-- Overlay info for fullscreen view -->
                <div id="overlayInfo" style="display: none;"></div>
                <canvas id="gameCanvas"></canvas>
            </div>
            <div id="mokeyPlayerContainer" class="hidden flex justify-center gap-2 mb-4">
                <img id="mokeyPlayer" src="https://cdn-icons-png.flaticon.com/512/1998/1998721.png" alt="Monkey" class="hidden w-16 h-16">
            </div>
        </div>
    </div>
    <!-- Puzzle Popup Modal -->
    <div id="puzzleModal" class="popup">
        <div class="popup-content">
            <h2 class="text-2xl font-bold text-yellow-400 mb-4">Solve the Puzzle</h2>
            <!-- The puzzle image will be loaded here via AJAX -->
            <img id="puzzleQuestionImage" src="" alt="Puzzle" style="max-width: 100%; margin-bottom: 10px;">
            <input type="text" id="puzzleAnswer" class="p-2 rounded" placeholder="Enter your answer">
            <button id="submitAnswerBtn" class="game-button py-2 px-6 text-white w-full mt-4">Submit</button>
        </div>
    </div>
    <!-- Feedback Popup Modal -->
    <div id="feedbackModal" class="popup">
        <div class="popup-content">
            <!-- Show a responsive monkey image for success/fail -->
            <img id="feedbackImage" class="feedback-image" src="" alt="Feedback Image" />
            <p id="feedbackMessage" class="text-lg text-white"></p>
            <button id="feedbackCloseBtn" class="game-button py-2 px-6 text-white w-full mt-4">OK</button>
        </div>
    </div>
</div>

<script>
    let score = 0;
    let level = 1;
    let selectedDifficulty = 'Medium';
    let bananaCounter = 3;
    let rows = [];
    let doors = [];
    let gameStarted = false;
    const username = '<?php echo htmlspecialchars($username); ?>';

    const scoreDisplay = document.getElementById('scoreDisplay');
    const levelDisplay = document.getElementById('levelDisplay');
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');
    const mokeyPlayerContainer = document.getElementById('mokeyPlayerContainer');
    const overlayInfo = document.getElementById('overlayInfo');
    const canvasContainer = document.getElementById('canvasContainer');

    const doorImage = new Image();
    doorImage.src = 'http://localhost/banana-quest/frontend/assets/images/lookedBanana.png';
    const monkeyImage = new Image();
    monkeyImage.src = 'https://cdn-icons-png.flaticon.com/512/1998/1998721.png';
    const monkeyPreStartImage = new Image();
    monkeyPreStartImage.src = 'https://cdn-icons-png.flaticon.com/512/1998/1998721.png';

    const doorSize = 80;
    const bigDoorSize = 100;
    const rowHeight = 20;
    const rowSpacing = 120;
    const monkeySize = 60;

    let monkey = {
        x: canvas.width / 2 - monkeySize / 2,
        y: 0,
        row: 0
    };

    const difficultySettings = {
        Easy: { startDoors: 1, increment: 1 },
        Medium: { startDoors: 2, increment: 2 },
        Hard: { startDoors: 3, increment: 3 }
    };

    function adjustCanvasDimensions() {
        if (canvasContainer.classList.contains('fullscreen')) {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        } else {
            canvas.width = canvasContainer.offsetWidth;
            canvas.height = 500;
        }
    }

    function updateDisplay() {
        scoreDisplay.textContent = score;
        levelDisplay.textContent = level;
        document.getElementById('bananaCounter').textContent = `Bananas: ${bananaCounter}`;
        if (canvasContainer.classList.contains('fullscreen')) {
            overlayInfo.innerHTML = `Score: ${score} | Level: ${level}`;
        }
    }

    // Doors are set up without local puzzle data.
    function setupLevel(level, difficulty) {
        const settings = difficultySettings[difficulty];
        const numberOfRows = settings.startDoors + (level - 1) * settings.increment;
        rows = [];
        for (let i = 1; i <= numberOfRows; i++) {
            rows.push({ y: i * rowSpacing });
        }
        canvas.height = Math.max(400, (numberOfRows + 2) * rowSpacing);
        // Create door objects.
        doors = rows.map((row, index) => ({
            x: Math.random() * (canvas.width - doorSize),
            y: row.y - doorSize,
            row: index + 1,
            cleared: false
        }));
        bananaCounter = 3 * level;
        monkey.row = rows.length;
        monkey.y = rows[rows.length - 1].y - monkeySize / 2;
        mokeyPlayerContainer.style.display = 'block';
        drawCanvas();
    }

    function allDoorsCleared() {
        return doors.every(door => door.cleared);
    }

    function drawCanvas() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (!gameStarted) {
            const doorX = canvas.width / 2 - bigDoorSize / 2;
            const doorY = 100;
            ctx.drawImage(doorImage, doorX, doorY, bigDoorSize, bigDoorSize);
            const monkeyX = doorX - monkeySize - 10;
            const monkeyY = doorY + bigDoorSize / 2 - monkeySize / 2;
            ctx.drawImage(monkeyPreStartImage, monkeyX, monkeyY, monkeySize, monkeySize);
            ctx.fillStyle = "yellow";
            ctx.font = "30px sans-serif";
            ctx.textAlign = "center";
            ctx.fillText("Get me to the jangule", canvas.width / 2, 250);

            const difficultyY = 300;
            const difficulties = ["Easy", "Medium", "Hard"];
            const xPositions = [canvas.width / 4, canvas.width / 2, 3 * canvas.width / 4];
            ctx.font = "20px sans-serif";
            difficulties.forEach((diff, index) => {
                ctx.fillText(diff, xPositions[index], difficultyY);
                if (selectedDifficulty === diff) {
                    const textWidth = 100;
                    const textHeight = 30;
                    ctx.strokeStyle = "yellow";
                    ctx.lineWidth = 2;
                    ctx.strokeRect(xPositions[index] - textWidth / 2, difficultyY - textHeight / 2, textWidth, textHeight);
                }
            });

            const startGameY = 350;
            ctx.fillText("Start Game", canvas.width / 2, startGameY);
        } else if (monkey.row === 1 && allDoorsCleared()) {
            const doorX = canvas.width / 2 - bigDoorSize / 2;
            const doorY = canvas.height / 2 - bigDoorSize / 2;
            ctx.drawImage(doorImage, doorX, doorY, bigDoorSize, bigDoorSize);
            const monkeyX = doorX - monkeySize - 10;
            const monkeyY = doorY + bigDoorSize / 2 - monkeySize / 2;
            ctx.drawImage(monkeyPreStartImage, monkeyX, monkeyY, monkeySize, monkeySize);
            ctx.fillStyle = "yellow";
            ctx.font = "20px sans-serif";
            ctx.textAlign = "center";
            ctx.fillText("Enter this door to go to next level", canvas.width / 2, doorY + bigDoorSize + 30);
        } else {
            ctx.fillStyle = '#8B4513';
            rows.forEach(row => {
                ctx.fillRect(0, row.y, canvas.width, rowHeight);
            });
            doors.forEach(door => {
                if (!door.cleared) {
                    ctx.drawImage(doorImage, door.x, door.y, doorSize, doorSize);
                }
            });
            ctx.drawImage(monkeyImage, monkey.x, monkey.y, monkeySize, monkeySize);
        }
    }

    // Global variable to store the currently selected door.
    let currentDoor = null;

    // Show the puzzle modal and fetch a puzzle via AJAX.
    function showPuzzlePopup(door) {
        currentDoor = door;
        // Use AJAX (GET) to fetch a new puzzle from puzzle_ajax.php.
        fetch('http://localhost/banana-quest/backend/puzzle_ajax.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Set the puzzle image in the modal.
                    document.getElementById('puzzleQuestionImage').src = data.question;
                    document.getElementById('puzzleAnswer').value = '';
                    document.getElementById('puzzleModal').style.display = 'flex';
                } else {
                    showFeedback(
                        "Uh-oh! We couldn't fetch a puzzle. " + data.message,
                        "http://localhost/banana-quest/frontend/assets/images/hungryMonkey.png"
                    );
                }
            })
            .catch(err => {
                console.error(err);
                showFeedback(
                    "Oops! Something went wrong with our puzzle service.",
                    "http://localhost/banana-quest/frontend/assets/images/hungryMonkey.png"
                );
            });
    }

    // When the submit button is clicked, send the answer via AJAX (POST) for verification.
    document.getElementById('submitAnswerBtn').addEventListener('click', () => {
        const answer = document.getElementById('puzzleAnswer').value.trim();
        if (!answer) {
            showFeedback(
                "Please share your answer so the monkey can enjoy a banana!",
                "http://localhost/banana-quest/frontend/assets/images/hungryMonkey.png"
            );
            return;
        }
        const formData = new URLSearchParams();
        formData.append('answer', answer);
        fetch('http://localhost/banana-quest/backend/puzzle_ajax.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('puzzleModal').style.display = 'none';
            if (data.status === 'success') {
                // Answer is correct. Mark the door as cleared.
                currentDoor.cleared = true;
                score += 2;
                updateDisplay();
                drawCanvas();
                // Move the monkey if this door's row matches the monkey's row.
                if (currentDoor.row === monkey.row) {
                    if (monkey.row > 1) {
                        monkey.row--;
                        monkey.y = rows[monkey.row - 1].y - monkeySize / 2;
                    }
                    drawCanvas();
                }
                showFeedback(
                    "Yay! You fed the monkey a yummy banana!",
                    "http://localhost/banana-quest/frontend/assets/images/happyMonkey.png"
                );
            } else if (data.status === 'fail') {
                showFeedback(
                    "Oh no! The monkey is still hungry. Try again!",
                    "http://localhost/banana-quest/frontend/assets/images/hungryMonkey.png"
                );
            } else {
                showFeedback(
                    "Oops! " + data.message,
                    "http://localhost/banana-quest/frontend/assets/images/hungryMonkey.png"
                );
            }
        })
        .catch(err => {
            console.error(err);
            document.getElementById('puzzleModal').style.display = 'none';
            showFeedback(
                "Oops! There was an error checking your answer.",
                "http://localhost/banana-quest/frontend/assets/images/hungryMonkey.png"
            );
        });
    });

    // Feedback modal functions.
    function showFeedback(message, imageUrl) {
        document.getElementById('feedbackMessage').textContent = message;
        // Show a relevant monkey image in the feedback modal.
        if (imageUrl) {
            document.getElementById('feedbackImage').src = imageUrl;
        }
        document.getElementById('feedbackModal').style.display = 'flex';
    }

    document.getElementById('feedbackCloseBtn').addEventListener('click', () => {
        document.getElementById('feedbackModal').style.display = 'none';
    });

    canvas.addEventListener('click', (event) => {
        const rect = canvas.getBoundingClientRect();
        const clickX = event.clientX - rect.left;
        const clickY = event.clientY - rect.top;

        if (!gameStarted) {
            const difficultyY = 300;
            const xPositions = [canvas.width / 4, canvas.width / 2, 3 * canvas.width / 4];
            const textWidth = 100;
            const textHeight = 30;
            const difficulties = ["Easy", "Medium", "Hard"];
            difficulties.forEach((diff, index) => {
                const rectX = xPositions[index] - textWidth / 2;
                const rectY = difficultyY - textHeight / 2;
                if (clickX >= rectX && clickX <= rectX + textWidth &&
                    clickY >= rectY && clickY <= rectY + textHeight) {
                    selectedDifficulty = diff;
                    drawCanvas();
                }
            });

            const startGameY = 350;
            const startRectX = canvas.width / 2 - 75;
            const startRectY = startGameY - 15;
            const startWidth = 150;
            const startHeight = 30;
            if (clickX >= startRectX && clickX <= startRectX + startWidth &&
                clickY >= startRectY && clickY <= startRectY + startHeight) {
                gameStarted = true;
                setupLevel(level, selectedDifficulty);
            }
        } else if (monkey.row === 1 && allDoorsCleared()) {
            const doorX = canvas.width / 2 - bigDoorSize / 2;
            const doorY = canvas.height / 2 - bigDoorSize / 2;
            if (clickX >= doorX && clickX <= doorX + bigDoorSize &&
                clickY >= doorY && clickY <= doorY + bigDoorSize) {
                sendGameDataToBackend(); // Send data before advancing to next level
                level++;
                setupLevel(level, selectedDifficulty);
            }
        } else {
            doors.forEach(door => {
                if (clickX >= door.x && clickX <= door.x + doorSize &&
                    clickY >= door.y && clickY <= door.y + doorSize) {
                    if (!door.cleared) {
                        showPuzzlePopup(door);
                    }
                }
            });
        }
    });

    function sendGameDataToBackend() {
        const gameData = {
            username: username,
            level: level,
            score: score,
            difficulty: selectedDifficulty,
            bananas: bananaCounter
        };

        fetch('http://localhost/banana-quest/backend/save_game_data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(gameData)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Game data saved successfully:', data);
        })
        .catch(error => {
            console.error('Error saving game data:', error);
        });
    }

    doorImage.onload = () => {
        adjustCanvasDimensions();
        drawCanvas();
    };
    updateDisplay();

    const expandBtn = document.getElementById('expandBtn');
    expandBtn.addEventListener('click', () => {
        canvasContainer.classList.toggle('fullscreen');
        if (canvasContainer.classList.contains('fullscreen')) {
            overlayInfo.style.display = 'block';
        } else {
            overlayInfo.style.display = 'none';
        }
        adjustCanvasDimensions();
        drawCanvas();
        updateDisplay();
    });

    window.addEventListener('resize', () => {
        if (!canvasContainer.classList.contains('fullscreen')) {
            adjustCanvasDimensions();
            drawCanvas();
            updateDisplay();
        }
    });
</script>
</body>
</html>
