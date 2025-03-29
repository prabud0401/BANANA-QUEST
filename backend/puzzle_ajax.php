<?php
session_start();
header('Content-Type: application/json');

// If an answer is provided, check it.
if (isset($_POST['answer'])) {
    $userAnswer = trim($_POST['answer']);

    // Ensure there's a puzzle solution stored.
    if (!isset($_SESSION['solution'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'No puzzle available. Please fetch a new puzzle first.'
        ]);
        exit;
    }
    
    // Check the user's answer.
    if ($userAnswer == $_SESSION['solution']) {
        // Clear the solution to avoid accidental reuse.
        unset($_SESSION['solution']);
        echo json_encode([
            'status'  => 'success',
            'message' => 'Correct answer!'
        ]);
        exit;
    } else {
        echo json_encode([
            'status'  => 'fail',
            'message' => 'Incorrect answer, please try again.'
        ]);
        exit;
    }
}

// If no answer provided, fetch a new puzzle from the Banana API.
$apiUrl = "https://marcconrad.com/uob/banana/api.php?out=json";
$response = file_get_contents($apiUrl);
if ($response === false) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Unable to fetch puzzle from the API.'
    ]);
    exit;
}

$data = json_decode($response, true);
if (!isset($data['question']) || !isset($data['solution'])) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Invalid API response.'
    ]);
    exit;
}

// Store the solution in the session for later verification.
$_SESSION['solution'] = $data['solution'];

// Return the puzzle image URL.
echo json_encode([
    'status'   => 'success',
    'question' => $data['question']
]);
exit;
?>
