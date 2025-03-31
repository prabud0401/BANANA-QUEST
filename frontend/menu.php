<?php
$page_title = "Menu";
include 'header.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
$username = $_SESSION['username'] ?? 'Monkey';
?>

<div class="w-full h-full flex flex-col md:flex-row justify-around items-center ">
    <!-- Header Section (Top on Mobile, Left on Desktop) -->
    <div class="space-y-6 md:order-1 order-1 text-center w-full flex flex-col justify-center items-center">
        <div class="flex items-center justify-center gap-2 sm:gap-4">
            <i class="ri-gamepad-fill text-3xl sm:text-5xl md:text-6xl text-yellow-400 animate-spin-slow"></i>
            <h1 class="text-3xl sm:text-5xl md:text-7xl font-extrabold bg-gradient-to-r from-yellow-400 via-green-400 to-yellow-400 bg-clip-text text-transparent">BANANA QUEST</h1>
        </div>
        <p class="text-base sm:text-xl md:text-2xl text-yellow-100 font-medium tracking-wide px-2"><span class="border-b-2 border-yellow-400">Swing • Collect • Conquer</span></p>
        <img src="http://localhost/banana-quest/frontend/assets/images/logoN.png" alt="Monkey Icon" class="w-24 sm:w-40 md:w-64 lg:w-80 monkey-float cursor-pointer hover:scale-110 transition-transform mx-auto">
        <p class="text-xl sm:text-2xl md:text-3xl text-yellow-400 font-bold">Welcome, <?php echo htmlspecialchars($username); ?>!</p>
        <button id="soundToggle" class="game-button py-2 px-6 text-base sm:text-lg md:text-lg text-white flex items-center gap-2 mx-auto"><i class="ri-volume-up-fill"></i> Sound: On</button>
    </div>
    <!-- Menu Options (Bottom on Mobile, Right on Desktop) -->
    <div class="flex flex-col gap-6 justify-center items-center w-full md:order-2 order-2 text-center w-full">
        <a href="game.php" class="game-button w-full md:max-w-72 py-6 md:px-6 md:py-4 text-xl sm:text-2xl md:text-lg font-bold uppercase tracking-widest flex-shrink-0">
            <i class="ri-play-fill mr-4"></i>Play Game
        </a>
        <a href="leaderboard.php" class="game-button w-full md:max-w-72 py-6 md:px-6 md:py-4 text-xl sm:text-2xl md:text-lg font-bold uppercase tracking-widest flex-shrink-0">
            <i class="ri-trophy-line mr-4"></i>Leaderboard
        </a>
        <a href="profile.php" class="game-button w-full md:max-w-72 py-6 md:px-6 md:py-4 text-xl sm:text-2xl md:text-lg font-bold uppercase tracking-widest flex-shrink-0">
            <i class="ri-user-line mr-4"></i>Profile
        </a>
        <a href="../backend/logout.php" class="game-button w-full md:max-w-72 py-6 md:px-6 md:py-4 text-xl sm:text-2xl md:text-lg font-bold uppercase tracking-widest flex-shrink-0">
            <i class="ri-logout-box-line mr-4"></i>Logout
        </a>
    </div>
</div>

<?php include 'http://localhost/banana-quest/frontend/footer.php'; ?>

<script>
    const soundToggle = document.getElementById('soundToggle');
    let soundOn = true;
    soundToggle.addEventListener('click', () => {
        soundOn = !soundOn;
        soundToggle.innerHTML = soundOn ? '<i class="ri-volume-up-fill"></i> Sound: On' : '<i class="ri-volume-mute-fill"></i> Sound: Off';
    });
</script>
