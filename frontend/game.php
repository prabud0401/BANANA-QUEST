<?php
$page_title = "Game";
include 'header.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
$username = $_SESSION['username'] ?? 'Monkey';
?>
<!DOCTYPE html>
<html>
<head>
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
        .game-info {
            background: rgba(58, 98, 19, 0.9);
            border: 2px solid #facc15;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<div class="w-full h-full flex flex-col md:flex-row justify-around items-center">
    <span class="extra-glow"></span>
    <!-- Left Side: Profile Area -->
    <div class="w-full md:w-1/2 flex flex-col items-center justify-between p-4 profile-section">
        <div class="profile-box w-full max-w-lg text-center space-y-4 p-4">
            <div class="space-y-6 animate-pulse">
                <div class="flex items-center justify-center gap-2 sm:gap-4">
                    <i class="ri-gamepad-fill text-3xl sm:text-5xl md:text-6xl text-yellow-400 animate-spin-slow"></i>
                    <h1 class="text-3xl sm:text-5xl font-extrabold bg-gradient-to-r from-yellow-400 via-green-400 to-yellow-400 bg-clip-text text-transparent">BANANA QUEST</h1>
                </div>
                <p class="text-base sm:text-xl md:text-2xl text-yellow-100 font-medium tracking-wide px-2"><span class="border-b-2 border-yellow-400">Game Mode</span></p>
            </div>
            <img src="http://localhost/banana-quest/frontend/assets/images/logoN.png" alt="Monkey Icon" class="w-24 sm:w-40 md:w-64 lg:w-80 monkey-float cursor-pointer hover:scale-110 transition-transform mx-auto">
            <p class="text-base sm:text-xl text-yellow-100 font-medium tracking-wide"><span class="border-b-2 border-yellow-400"><?php echo htmlspecialchars($username); ?></span></p>
            <div class="text-yellow-400 space-y-2">
                <h2 class="text-2xl sm:text-3xl font-bold">Swing into Action!</h2>
                <p class="text-lg sm:text-xl">Get ready to play!</p>
            </div>
        </div>
        <a href="menu.php" class="game-button py-2 px-6 text-lg text-white flex items-center justify-center mt-4">
            <i class="ri-arrow-left-line mr-2"></i> Back to Menu
        </a>
    </div>
    <!-- Right Side: Game Display Area -->
    <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-4 game-section">
        <div class="w-full max-w-2xl text-center space-y-4 p-4">
            <div class="game-info flex justify-between text-yellow-400 font-bold text-lg">
                <span>Score: <span id="scoreDisplay">0</span></span>
                <span>Level: <span id="levelDisplay">1</span></span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-yellow-400 mb-4">Banana Quest</h2>
            <div id="bananaCounter" class="text-yellow-400 font-bold text-lg mb-4">Bananas: 3</div>
            <canvas id="gameCanvas" width="600" height="400"></canvas>
            <div id="monkey" class="flex justify-center gap-2 mb-4">
                <img id="mokeyPlayer" src="https://cdn-icons-png.flaticon.com/512/1998/1998721.png" alt="Monkey" class="w-16 h-16">
            </div>
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
    <!-- Puzzle Popup -->
    <div id="puzzleModal" class="popup" style="display: none;">
        <div class="popup-content">
            <h2 class="text-2xl font-bold text-yellow-400 mb-4">Solve the Puzzle</h2>
            <p id="puzzleQuestion" class="text-lg text-white mb-4"></p>
            <input type="text" id="puzzleAnswer" class="p-2 rounded" placeholder="Enter your answer">
            <button id="submitAnswerBtn" class="game-button py-2 px-6 text-white w-full mt-4">Submit</button>
        </div>
    </div>
</div>

<script>
    // Game tracking variables
    let score = 0;
    let level = 1;
    let selectedDifficulty = 'Medium';
    let bananaCounter = 3;
    let rows = [];
    let doors = [];

    // DOM elements
    const scoreDisplay = document.getElementById('scoreDisplay');
    const levelDisplay = document.getElementById('levelDisplay');
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');

    // Canvas elements
    const doorImage = new Image();
    doorImage.src = 'https://www.transparentpng.com/download/door-png/door-icon-png-9.png';
    const doorSize = 50;
    const rowHeight = 10;
    const rowSpacing = 100;

    // Monkey properties
    const monkeySize = 50;
    let monkey = {
        x: canvas.width / 2 - monkeySize / 2,
        y: canvas.height - monkeySize,
        row: 0 // Starting below the first row
    };

    // Difficulty settings
    const difficultySettings = {
        Easy: { startDoors: 1, increment: 1 },
        Medium: { startDoors: 2, increment: 2 },
        Hard: { startDoors: 3, increment: 3 }
    };

    // Update display function
    function updateDisplay() {
        scoreDisplay.textContent = score;
        levelDisplay.textContent = level;
        document.getElementById('bananaCounter').textContent = `Bananas: ${bananaCounter}`;
    }

    // Generate puzzle
    function generatePuzzle() {
        const x = Math.floor(Math.random() * 10);
        const y = Math.floor(Math.random() * 10);
        return {
            question: `What is ${x} + ${y}?`,
            answer: (x + y).toString()
        };
    }

    // Setup level
    function setupLevel(level, difficulty) {
        const settings = difficultySettings[difficulty];
        const numberOfRows = settings.startDoors + (level - 1) * settings.increment;

        // Generate rows
        rows = [];
        for (let i = 1; i <= numberOfRows; i++) {
            rows.push({ y: canvas.height - i * rowSpacing });
        }

        // Generate doors for each row
        doors = rows.map((row, index) => ({
            x: Math.random() * (canvas.width - doorSize),
            y: row.y - doorSize,
            row: index + 1,
            cleared: false,
            puzzle: generatePuzzle()
        }));

        // Add final door
        const finalDoorY = rows.length > 0 ? rows[rows.length - 1].y - rowSpacing : 50;
        doors.push({
            x: canvas.width / 2 - doorSize / 2,
            y: finalDoorY - doorSize,
            row: 'final',
            cleared: false
        });

        // Set bananaCounter
        bananaCounter = 3 * level;

        // Reset monkey position
        monkey.row = 0;
        monkey.y = canvas.height - monkeySize;

        // Draw canvas
        drawCanvas();
    }

    // Draw canvas elements
    function drawCanvas() {
        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Draw rows
        ctx.fillStyle = '#8B4513';
        rows.forEach(row => {
            ctx.fillRect(0, row.y, canvas.width, rowHeight);
        });

        // Draw doors if not cleared
        if (doorImage.complete) {
            doors.forEach(door => {
                if (!door.cleared) {
                    ctx.drawImage(doorImage, door.x, door.y, doorSize, doorSize);
                }
            });
        }

        // Draw monkey
        const monkeyImage = new Image();
        monkeyImage.src = 'https://cdn-icons-png.flaticon.com/512/1998/1998721.png';
        if (monkeyImage.complete) {
            ctx.drawImage(monkeyImage, monkey.x, monkey.y, monkeySize, monkeySize);
        }
    }

    // Handle door clicks
    canvas.addEventListener('click', (event) => {
        const rect = canvas.getBoundingClientRect();
        const clickX = event.clientX - rect.left;
        const clickY = event.clientY - rect.top;

        doors.forEach(door => {
            if (clickX >= door.x && clickX <= door.x + doorSize &&
                clickY >= door.y && clickY <= door.y + doorSize) {
                if (door.row === 'final' && areAllRowDoorsCleared()) {
                    // Complete the level
                    score += bananaCounter * 10;
                    updateDisplay();
                    level++;
                    setupLevel(level, selectedDifficulty);
                } else if (!door.cleared && door.row !== 'final') {
                    showPuzzlePopup(door);
                }
            }
        });
    });

    // Show puzzle popup
    let currentDoor = null;
    function showPuzzlePopup(door) {
        currentDoor = door;
        document.getElementById('puzzleQuestion').textContent = door.puzzle.question;
        document.getElementById('puzzleAnswer').value = '';
        document.getElementById('puzzleModal').style.display = 'flex';
    }

    // Handle submit answer
    document.getElementById('submitAnswerBtn').addEventListener('click', () => {
        const answer = document.getElementById('puzzleAnswer').value.trim();
        if (answer === currentDoor.puzzle.answer) {
            // Correct answer
            currentDoor.cleared = true;
            score += 2;
            updateDisplay();
            document.getElementById('puzzleModal').style.display = 'none';
            drawCanvas();
            // Move monkey if applicable
            if (monkey.row === currentDoor.row - 1) {
                monkey.row++;
                monkey.y = rows[monkey.row - 1].y - monkeySize;
                drawCanvas();
            }
        } else {
            alert('Incorrect answer. Try again!');
        }
    });

    // Check if all row doors are cleared
    function areAllRowDoorsCleared() {
        return doors.filter(door => door.row !== 'final').every(door => door.cleared);
    }

    // Difficulty selection handling
    const difficultyButtons = document.querySelectorAll('.difficulty-btn');
    const startGameBtn = document.getElementById('startGameBtn');
    const difficultyModal = document.getElementById('difficultyModal');

    difficultyButtons.forEach(button => {
        button.addEventListener('click', () => {
            difficultyButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            selectedDifficulty = button.dataset.difficulty;
        });
    });

    startGameBtn.addEventListener('click', () => {
        difficultyModal.style.display = 'none';
        console.log(`Selected difficulty: ${selectedDifficulty}`);
        updateDisplay();
        setupLevel(level, selectedDifficulty);
    });

    // Initial setup
    doorImage.onload = () => {
        drawCanvas();
    };
    updateDisplay();
</script>
</body>
</html>