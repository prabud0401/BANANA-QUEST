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
    <link href="http://localhost/banana-quest/frontend/assets/css/main.css" rel="stylesheet">
</head>
<body class="jungle-bg flex items-center justify-center p-4 sm:p-6 relative w-full">
    <div class="crt-effect"></div>
    <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23facc15'><path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-2h2v2h-2zm0-4V7h2v6h-2z'/></svg>" class="banana-deco w-12 h-12 top-10 left-10 sm:w-16 sm:h-16" alt="Banana">
    <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23facc15'><path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-2h2v2h-2zm0-4V7h2v6h-2z'/></svg>" class="banana-deco w-10 h-10 bottom-20 right-12 sm:w-14 sm:h-14" alt="Banana">
    
<?php
?>