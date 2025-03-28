<?php
$page_title = "Login";
include 'header.php';
?>
<div class="w-full h-[100vh] flex justify-center items-center login-container">
    <span class="extra-glow"></span> <!-- Extra glow layer -->
    <div class="relative z-10 w-full max-w-md sm:max-w-lg md:max-w-2xl text-center flex flex-col items-center space-y-6 sm:space-y-8">
        <div class="space-y-4 animate-pulse">
            <div class="flex items-center justify-center gap-2 sm:gap-4">
                <i class="ri-gamepad-fill text-2xl sm:text-4xl md:text-5xl text-yellow-400 animate-spin-slow"></i>
                <h1 class="text-2xl sm:text-4xl md:text-6xl font-extrabold bg-gradient-to-r from-yellow-400 via-green-400 to-yellow-400 bg-clip-text text-transparent">BANANA QUEST</h1>
            </div>
            <p class="text-sm sm:text-lg md:text-xl text-yellow-100 font-medium tracking-wide px-2"><span class="border-b-2 border-yellow-400">Swing • Collect • Conquer</span></p>
        </div>
        <img src="http://localhost/banana-quest/frontend/assets/images/logoN.png" alt="Monkey Icon" class="w-40 sm:w-40 md:w-64 lg:w-80 monkey-float cursor-pointer hover:scale-110 transition-transform mx-auto">
        <button id="soundToggle" class="game-button py-1 px-3 text-sm sm:text-base text-white flex items-center gap-2"><i class="ri-volume-up-fill"></i> Sound: On</button>
        <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6 w-full">
            <button id="loginBtn" class="game-button w-full md:max-w-72 py-6 md:px-6 md:py-4 text-xl sm:text-2xl md:text-lg font-bold uppercase tracking-widest flex-shrink-0">Swing In</button>
            <button id="signupBtn" class="game-button w-full md:max-w-72 py-6 md:px-6 md:py-4 text-xl sm:text-2xl md:text-lg font-bold uppercase tracking-widest flex-shrink-0">Start Adventure</button>
        </div>
    </div>
    <div id="loginPopup" class="popup">
        <div class="popup-content">
            <h2 class="text-2xl font-bold text-yellow-400 mb-4">Monkey Login</h2>
            <form id="loginForm">
                <input type="text" name="username" placeholder="Your Monkey Name" class="w-full p-2 mb-4 rounded border border-yellow-400 bg-green-800 text-white" required>
                <input type="password" name="password" placeholder="Secret Banana Code" class="w-full p-2 mb-4 rounded border border-yellow-400 bg-green-800 text-white" required>
                <button type="submit" class="game-button py-2 px-6 text-white w-full">Hop In!</button>
            </form>
            <button id="closeLogin" class="mt-4 text-yellow-400 hover:text-yellow-300">Swing Away</button>
        </div>
    </div>
    <div id="signupPopup" class="popup">
        <div class="popup-content">
            <h2 class="text-2xl font-bold text-yellow-400 mb-4">Join the Jungle</h2>
            <form id="signupForm">
                <input type="text" name="username" placeholder="Pick a Monkey Name" class="w-full p-2 mb-4 rounded border border-yellow-400 bg-green-800 text-white" required>
                <input type="email" name="email" placeholder="Banana Mail" class="w-full p-2 mb-4 rounded border border-yellow-400 bg-green-800 text-white" required>
                <input type="password" name="password" placeholder="Secret Banana Code" class="w-full p-2 mb-4 rounded border border-yellow-400 bg-green-800 text-white" required>
                <input type="password" name="confirm_password" placeholder="Repeat Banana Code" class="w-full p-2 mb-4 rounded border border-yellow-400 bg-green-800 text-white" required>
                <button type="submit" class="game-button py-2 px-6 text-white w-full">Join the Troop!</button>
            </form>
            <button id="closeSignup" class="mt-4 text-yellow-400 hover:text-yellow-300">Swing Away</button>
        </div>
    </div>
    <div id="loading" class="loading"><i class="ri-loader-4-line text-4xl text-yellow-400"></i></div>
    <div id="resultMessage" class="result-message"></div>
</div>
</body>

</html>
<script>
    const soundToggle = document.getElementById('soundToggle');
    let soundOn = true;
    soundToggle.addEventListener('click', () => {
        soundOn = !soundOn;
        soundToggle.innerHTML = soundOn ? '<i class="ri-volume-up-fill"></i> Sound: On' : '<i class="ri-volume-mute-fill"></i> Sound: Off';
    });
    const loginBtn = document.getElementById('loginBtn');
    const signupBtn = document.getElementById('signupBtn');
    const loginPopup = document.getElementById('loginPopup');
    const signupPopup = document.getElementById('signupPopup');
    const closeLogin = document.getElementById('closeLogin');
    const closeSignup = document.getElementById('closeSignup');
    const loading = document.getElementById('loading');
    const resultMessage = document.getElementById('resultMessage');
    loginBtn.addEventListener('click', () => loginPopup.style.display = 'flex');
    signupBtn.addEventListener('click', () => signupPopup.style.display = 'flex');
    closeLogin.addEventListener('click', () => loginPopup.style.display = 'none');
    closeSignup.addEventListener('click', () => signupPopup.style.display = 'none');
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        loading.style.display = 'block';
        try {
            const response = await fetch('http://localhost/banana-quest/backend/login.php', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            loading.style.display = 'none';
            resultMessage.textContent = data.message || (data.status === 'success' ? 'Yay, Success!' : 'Oops, Something Went Wrong');
            resultMessage.style.background = data.status === 'success' ? '#facc15' : '#ff4444';
            resultMessage.style.display = 'block';
            setTimeout(() => {
                resultMessage.style.display = 'none';
                if (data.status === 'success') {
                    loginPopup.style.display = 'none';
                    window.location.href = 'menu.php';
                }
            }, 3000);
        } catch (error) {
            loading.style.display = 'none';
            resultMessage.textContent = 'Jungle Network Trouble!';
            resultMessage.style.background = '#ff4444';
            resultMessage.style.display = 'block';
            setTimeout(() => resultMessage.style.display = 'none', 3000);
        }
    });
    document.getElementById('signupForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const password = formData.get('password');
        const confirmPassword = formData.get('confirm_password');
        if (password !== confirmPassword) {
            resultMessage.textContent = 'Banana Codes don\'t match!';
            resultMessage.style.background = '#ff4444';
            resultMessage.style.display = 'block';
            setTimeout(() => resultMessage.style.display = 'none', 3000);
            return;
        }
        loading.style.display = 'block';
        try {
            const response = await fetch('http://localhost/banana-quest/backend/signup.php', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            loading.style.display = 'none';
            resultMessage.textContent = data.message || (data.status === 'success' ? 'Yay, Success!' : 'Oops, Something Went Wrong');
            resultMessage.style.background = data.status === 'success' ? '#facc15' : '#ff4444';
            resultMessage.style.display = 'block';
            setTimeout(() => {
                resultMessage.style.display = 'none';
                if (data.status === 'success') {
                    signupPopup.style.display = 'none';
                    e.target.reset();
                }
            }, 3000);
        } catch (error) {
            loading.style.display = 'none';
            resultMessage.textContent = 'Jungle Network Trouble!';
            resultMessage.style.background = '#ff4444';
            resultMessage.style.display = 'block';
            setTimeout(() => resultMessage.style.display = 'none', 3000);
        }
    });
</script>