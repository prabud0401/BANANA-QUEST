<?php
session_start();

include 'http://localhost/banana-quest/backend/db_connect.php';
include 'http://localhost/banana-quest/backend/functions.php';

include 'http://localhost/banana-quest/frontend/header.php';
?>    
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
        <img src="http://localhost/banana-quest/frontend/assets/images/logoN.png" 
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
<?php
include 'http://localhost/banana-quest/frontend/footer.php';
?>  