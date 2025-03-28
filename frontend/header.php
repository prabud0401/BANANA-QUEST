<?php
// header.php
session_start(); // Start session for all pages
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banana Quest - <?php echo htmlspecialchars($page_title ?? 'Home'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="http://localhost/banana-quest/frontend/assets/css/jungle-bg.css" rel="stylesheet">
    <style>
        @keyframes float { 0%, 100% { transform: translateY(0) rotate(-2deg); } 50% { transform: translateY(-25px) rotate(2deg); } }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .monkey-float { 
            animation: float 3.5s ease-in-out infinite; 
            filter: drop-shadow(0 12px 10px rgba(0,0,0,0.4)); 
        }
        .popup { 
            display: none; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0, 0, 0, 0.8); 
            z-index: 1000; 
            justify-content: center; 
            align-items: center; 
        }
        .popup-content { 
            background: linear-gradient(145deg, #4d7c0f, #3b6213); 
            border: 4px solid #facc15; 
            border-radius: 20px; 
            padding: 2rem; 
            width: 90%; 
            max-width: 400px; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); 
        }
        .loading { 
            display: none; 
            position: absolute; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            z-index: 1001; 
        }
        .loading i { 
            animation: spin 1s linear infinite; 
        }
        .result-message { 
            display: none; 
            position: fixed; 
            top: 20%; 
            left: 50%; 
            transform: translateX(-50%); 
            background: #facc15; 
            color: #1a2f1d; 
            padding: 1rem 2rem; 
            border-radius: 12px; 
            font-weight: bold; 
            z-index: 1002; 
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); 
        }
    </style>
</head>
<body class="jungle-bg flex items-center justify-center p-4 sm:p-6 relative w-full">
    <div class="crt-effect"></div>
    <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23facc15'><path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-2h2v2h-2zm0-4V7h2v6h-2z'/></svg>" class="banana-deco w-12 h-12 top-10 left-10 sm:w-16 sm:h-16" alt="Banana">
    <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23facc15'><path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-2h2v2h-2zm0-4V7h2v6h-2z'/></svg>" class="banana-deco w-10 h-10 bottom-20 right-12 sm:w-14 sm:h-14" alt="Banana">
    
        <!-- Page-specific content goes here -->
<?php
// Page content will be injected here by including files
?>