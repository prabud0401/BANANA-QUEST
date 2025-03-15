<?php
session_start();
include 'config.php';

$error = [];

// Handle Login
if(isset($_POST['login_submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $select = "SELECT * FROM player_form WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username;
        header('Location: menu.php');
        exit();
    } else {
        $error[] = 'Incorrect username or password!';
    }
}

// Handle Signup
if(isset($_POST['signup_submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $confirmPassword = md5($_POST['confirmPassword']);

    $check_user = "SELECT * FROM player_form WHERE username = '$username'";
    $res = mysqli_query($conn, $check_user);

    if(mysqli_num_rows($res) > 0) {
        $error[] = 'Username already exists!';
    } else {
        if($password != $confirmPassword) {
            $error[] = 'Passwords do not match!';
        } else {
            $insert = "INSERT INTO player_form(username, password) VALUES('$username', '$password')";
            if(mysqli_query($conn, $insert)) {
                $_SESSION['username'] = $username;
                header('Location: menu.php');
                exit();
            } else {
                $error[] = 'Registration failed!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banana Quest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        /* Game-themed animations */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes background-scroll {
            0% { background-position: 0 0; }
            100% { background-position: 100% 0; }
        }

        .game-bg {
            background: linear-gradient(45deg, #1a2f1d, #2d4a32);
            position: relative;
            overflow: hidden;
        }

        .game-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 200%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M50 5L20 40l30-15 30 15z" fill="%234f772d" opacity="0.1"/></svg>');
            animation: background-scroll 60s linear infinite;
        }

        .game-button {
            position: relative;
            border: 3px solid #facc15;
            border-radius: 16px;
            background: linear-gradient(145deg, #4d7c0f, #3b6213);
            box-shadow: 0 8px 24px rgba(250, 204, 21, 0.3);
            transition: all 0.3s ease;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .game-button:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 12px 32px rgba(250, 204, 21, 0.5);
        }

        .game-modal {
            background: linear-gradient(145deg, #1a2f1d, #142115);
            border: 3px solid #facc15;
            border-radius: 16px;
            box-shadow: 0 0 40px rgba(250, 204, 21, 0.2);
            position: relative;
            overflow: hidden;
        }

        .game-modal::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(250, 204, 21, 0.1),
                transparent
            );
            animation: modal-glow 6s linear infinite;
        }

        @keyframes modal-glow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .monkey-float {
            animation: float 3s ease-in-out infinite;
            filter: drop-shadow(0 10px 8px rgba(0,0,0,0.3));
        }

        .crt-effect {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(0deg, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0.2) 50%);
            background-size: 100% 4px;
            pointer-events: none;
            z-index: 999;
            mix-blend-mode: overlay;
        }

        .input-glitch {
            position: relative;
            background: rgba(0,0,0,0.4);
            border: 2px solid #4d7c0f;
            transition: all 0.3s ease;
        }

        .input-glitch:hover {
            border-color: #facc15;
            box-shadow: 0 0 15px rgba(250, 204, 21, 0.3);
        }

        .pixel-border {
            position: relative;
            border: 3px solid #4d7c0f;
            border-image: repeating-linear-gradient(
                45deg,
                #4d7c0f,
                #4d7c0f 10px,
                #facc15 10px,
                #facc15 20px
            ) 30;
        }
    </style>
</head>
<body class="game-bg min-h-screen flex items-center justify-center p-4">
    <!-- CRT Effect -->
    <div class="crt-effect"></div>
    
    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-2xl text-center flex flex-col items-center space-y-8">
        <!-- Animated Header -->
        <div class="space-y-6 animate-pulse">
            <div class="flex items-center justify-center gap-4">
                <i class="ri-gamepad-fill text-5xl text-yellow-400 animate-spin-slow"></i>
                <h1 class="text-5xl md:text-6xl font-black bg-gradient-to-r from-yellow-400 to-green-400 bg-clip-text text-transparent">
                    BANANA QUEST
                </h1>
            </div>
            <p class="text-xl text-yellow-100 font-medium tracking-wide">
                <span class="border-b-2 border-yellow-400">Solve Puzzles • Collect Treasures • Level Up</span>
            </p>
        </div>
        
        <!-- Animated Monkey Character -->
        <img src="https://static.vecteezy.com/system/resources/previews/052/243/093/non_2x/adorable-monkey-holding-banana-clipart-for-craft-projects-free-png.png" 
             alt="Monkey Icon" 
             class="w-32 md:w-48 monkey-float cursor-pointer hover:scale-110 transition-transform">

        <!-- Game Action Buttons -->
        <div class="flex flex-col md:flex-row gap-6 justify-center">
            <button onclick="openModal('login')" 
                    class="game-button text-yellow-100 px-10 py-5 text-xl font-bold uppercase tracking-wider">
                <i class="ri-controller-line mr-3"></i>Continue Adventure
            </button>
            <button onclick="openModal('signup')" 
                    class="game-button text-yellow-100 px-10 py-5 text-xl font-bold uppercase tracking-wider">
                <i class="ri-user-add-line mr-3"></i>New Game
            </button>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 bg-black/90 hidden backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="game-modal w-full max-w-md transform transition-all p-8">
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-yellow-400">
                        <i class="ri-controller-line mr-2"></i>Continue Quest
                    </h2>
                    <button onclick="closeModal('login')" class="text-yellow-400 hover:text-yellow-200 transition-colors">
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>

                <form method="POST" class="space-y-6">
                    <?php if(!empty($error)): ?>
                        <div class="bg-red-900/30 p-3 rounded-lg border-2 border-red-600">
                            <?php foreach($error as $err): ?>
                                <p class="text-red-300 text-sm"><i class="ri-alert-fill mr-2"></i><?= $err ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-yellow-300 mb-3">Adventurer Name</label>
                            <div class="relative">
                                <input type="text" name="username" required
                                       class="input-glitch w-full px-4 py-3 rounded-lg text-yellow-100 placeholder-yellow-400/60 focus:outline-none">
                                <i class="ri-user-3-line absolute right-4 top-3.5 text-yellow-400/60"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yellow-300 mb-3">Secret Code</label>
                            <div class="relative">
                                <input type="password" name="password" required
                                       class="input-glitch w-full px-4 py-3 rounded-lg text-yellow-100 placeholder-yellow-400/60 focus:outline-none">
                                <i class="ri-key-2-line absolute right-4 top-3.5 text-yellow-400/60"></i>
                            </div>
                        </div>
                        <button type="submit" name="login_submit"
                                class="game-button w-full text-yellow-100 px-8 py-4 text-lg font-bold uppercase tracking-wider">
                            <i class="ri-login-box-line mr-2"></i>Start Adventure
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Signup Modal -->
    <div id="signupModal" class="fixed inset-0 bg-black/90 hidden backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="game-modal w-full max-w-md transform transition-all p-8">
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-amber-400">
                        <i class="ri-user-add-line mr-2"></i>New Adventurer
                    </h2>
                    <button onclick="closeModal('signup')" class="text-amber-400 hover:text-amber-200 transition-colors">
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>

                <form method="POST" class="space-y-6">
                    <?php if(!empty($error)): ?>
                        <div class="bg-red-900/30 p-3 rounded-lg border-2 border-red-600">
                            <?php foreach($error as $err): ?>
                                <p class="text-red-300 text-sm"><i class="ri-alert-fill mr-2"></i><?= $err ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-amber-300 mb-3">Choose Adventurer Name</label>
                            <div class="relative">
                                <input type="text" name="username" required
                                       class="input-glitch w-full px-4 py-3 rounded-lg text-amber-100 placeholder-amber-400/60 focus:outline-none">
                                <i class="ri-user-add-line absolute right-4 top-3.5 text-amber-400/60"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-amber-300 mb-3">Create Secret Code</label>
                            <div class="relative">
                                <input type="password" name="password" required
                                       class="input-glitch w-full px-4 py-3 rounded-lg text-amber-100 placeholder-amber-400/60 focus:outline-none">
                                <i class="ri-key-2-line absolute right-4 top-3.5 text-amber-400/60"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-amber-300 mb-3">Confirm Secret Code</label>
                            <div class="relative">
                                <input type="password" name="confirmPassword" required
                                       class="input-glitch w-full px-4 py-3 rounded-lg text-amber-100 placeholder-amber-400/60 focus:outline-none">
                                <i class="ri-lock-check-line absolute right-4 top-3.5 text-amber-400/60"></i>
                            </div>
                        </div>
                        <button type="submit" name="signup_submit"
                                class="game-button w-full text-amber-100 px-8 py-4 text-lg font-bold uppercase tracking-wider">
                            <i class="ri-map-pin-add-line mr-2"></i>Begin Quest
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(type) {
            const modal = document.getElementById(`${type}Modal`);
            modal.classList.remove('hidden');
            modal.style.animation = 'modalEnter 0.3s ease-out';
        }

        function closeModal(type) {
            const modal = document.getElementById(`${type}Modal`);
            modal.style.animation = 'modalExit 0.3s ease-in';
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 250);
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) {
                closeModal(event.target.id.replace('Modal', ''));
            }
        }
    </script>
</body>
</html>