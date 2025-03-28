<?php
session_start();
header('Content-Type: application/json');

include 'db_connect.php';

function sendResponse($success, $data = [], $error = null) {
    echo json_encode(array_merge(['success' => $success], $data, $error ? ['error' => $error] : []));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type'])) {
    $type = $_POST['type'];

    if ($type === 'login') {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            sendResponse(false, [], 'Username and password are required.');
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['level'] = $user['level'];
            $_SESSION['score'] = $user['score'];

            $sessionId = bin2hex(random_bytes(16));
            $stmt = $pdo->prepare("INSERT INTO sessions (session_id, user_id) VALUES (?, ?)");
            $stmt->execute([$sessionId, $user['id']]);

            sendResponse(true, ['session_id' => $sessionId]);
        } else {
            sendResponse(false, [], 'Invalid username or password.');
        }
    } elseif ($type === 'signup') {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirmPassword'] ?? '');

        if (empty($username) || empty($password) || empty($confirmPassword)) {
            sendResponse(false, [], 'All fields are required.');
        }
        if ($password !== $confirmPassword) {
            sendResponse(false, [], 'Passwords do not match.');
        }
        if (strlen($username) < 3 || strlen($password) < 6) {
            sendResponse(false, [], 'Username must be at least 3 characters, password at least 6.');
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            sendResponse(false, [], 'Username already taken.');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]);
        $userId = $pdo->lastInsertId();

        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['level'] = 1;
        $_SESSION['score'] = 0;

        $sessionId = bin2hex(random_bytes(16));
        $stmt = $pdo->prepare("INSERT INTO sessions (session_id, user_id) VALUES (?, ?)");
        $stmt->execute([$sessionId, $userId]);

        sendResponse(true, ['session_id' => $sessionId]);
    } else {
        sendResponse(false, [], 'Invalid request type.');
    }
}

if (isset($_GET['action'])) {
    if (!isset($_SESSION['user_id'])) {
        sendResponse(false, [], 'You must be logged in.');
    }

    switch ($_GET['action']) {
        case 'getGameData':
            $score = $_SESSION['score'] + 10;
            $stmt = $pdo->prepare("UPDATE users SET score = ? WHERE id = ?");
            $stmt->execute([$score, $_SESSION['user_id']]);
            $_SESSION['score'] = $score;
            sendResponse(true, ['score' => $score]);
            break;

        case 'getLeaderboard':
            $stmt = $pdo->query("SELECT username, score FROM users ORDER BY score DESC LIMIT 10");
            $leaderboard = $stmt->fetchAll();
            sendResponse(true, ['leaderboard' => $leaderboard]);
            break;

        case 'getProfile':
            $stmt = $pdo->prepare("SELECT level, score FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $profile = $stmt->fetch();
            sendResponse(true, $profile);
            break;

        default:
            sendResponse(false, [], 'Invalid action.');
    }
}

sendResponse(false, [], 'Invalid request.');
?>