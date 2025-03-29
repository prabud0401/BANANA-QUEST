<?php
session_start();
$message = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If an answer was submitted, check it against the stored solution.
    if (isset($_POST['answer'])) {
        $userAnswer = trim($_POST['answer']);
        if (isset($_SESSION['solution']) && $userAnswer == $_SESSION['solution']) {
            $message = "Correct! Here's your next puzzle:";
            // Clear stored puzzle so a new one is fetched
            unset($_SESSION['question']);
            unset($_SESSION['solution']);
        } else {
            $message = "Incorrect! Please try again.";
        }
    }
}

// Fetch a new puzzle if needed
if (empty($_SESSION['question'])) {
    $apiUrl = "https://marcconrad.com/uob/banana/api.php?out=json";
    $response = file_get_contents($apiUrl);
    if ($response !== false) {
        $data = json_decode($response, true);
        if (isset($data['question']) && isset($data['solution'])) {
            $_SESSION['question'] = $data['question'];
            $_SESSION['solution'] = $data['solution'];
        } else {
            $message = "Error: Invalid API response.";
        }
    } else {
        $message = "Error: Unable to fetch puzzle from the API.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Banana Puzzle Game</title>
</head>
<body>
    <h1>Banana Puzzle Game</h1>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['question'])): ?>
        <img src="<?php echo htmlspecialchars($_SESSION['question']); ?>" alt="Puzzle Image" style="max-width: 300px;"><br><br>
        <form method="post">
            <input type="number" name="answer" placeholder="Enter your answer" required>
            <button type="submit">Submit</button>
        </form>
    <?php endif; ?>
</body>
</html>
