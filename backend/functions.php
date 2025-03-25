<?php
$error = [];

// Handle Login
if(isset($_POST['login_submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $select = "SELECT * FROM player_form WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username;
        header('Location: http://localhost/banana-quest/frontend/pages/menu.php');
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
                header('Location: http://localhost/banana-quest/frontend/pages/menu.php');
                exit();
            } else {
                $error[] = 'Registration failed!';
            }
        }
    }
}
?>