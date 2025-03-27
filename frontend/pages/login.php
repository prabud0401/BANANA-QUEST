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

                    <form id="loginForm" class="space-y-6" onsubmit="handleLogin(event)">
                        <div id="loginError" class="hidden bg-red-900/30 p-3 rounded-lg border-2 border-red-600"></div>
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
                            <button type="submit"
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

                    <form id="signupForm" class="space-y-6" onsubmit="handleSignup(event)">
                        <div id="signupError" class="hidden bg-red-900/30 p-3 rounded-lg border-2 border-red-600"></div>
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
                            <button type="submit"
                                    class="game-button w-full text-amber-100 px-8 py-4 text-lg font-bold uppercase tracking-wider">
                                <i class="ri-map-pin-add-line mr-2"></i>Begin Quest
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function handleLogin(event) {
                event.preventDefault();
                const form = document.getElementById('loginForm');
                const formData = new FormData(form);
                const errorDiv = document.getElementById('loginError');

                // AJAX call to backend function 'loginUser'
                fetch('http://localhost/banana-quest/backend/functions.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeModal('login');
                        window.location.href = '?page=menu'; // Redirect to menu after login
                    } else {
                        errorDiv.classList.remove('hidden');
                        errorDiv.innerHTML = `<p class="text-red-300 text-sm"><i class="ri-alert-fill mr-2"></i>${data.error}</p>`;
                    }
                })
                .catch(error => {
                    errorDiv.classList.remove('hidden');
                    errorDiv.innerHTML = `<p class="text-red-300 text-sm"><i class="ri-alert-fill mr-2"></i>Login failed. Try again.</p>`;
                });
            }

            function handleSignup(event) {
                event.preventDefault();
                const form = document.getElementById('signupForm');
                const formData = new FormData(form);
                const errorDiv = document.getElementById('signupError');

                // AJAX call to backend function 'signupUser'
                fetch('http://localhost/banana-quest/backend/functions.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeModal('signup');
                        window.location.href = '?page=menu'; // Redirect to menu after signup
                    } else {
                        errorDiv.classList.remove('hidden');
                        errorDiv.innerHTML = `<p class="text-red-300 text-sm"><i class="ri-alert-fill mr-2"></i>${data.error}</p>`;
                    }
                })
                .catch(error => {
                    errorDiv.classList.remove('hidden');
                    errorDiv.innerHTML = `<p class="text-red-300 text-sm"><i class="ri-alert-fill mr-2"></i>Signup failed. Try again.</p>`;
                });
            }
        </script>
