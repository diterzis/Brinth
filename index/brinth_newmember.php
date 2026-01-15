<?php
require 'brinth-database.php';
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../loggedin/protected_page.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM playerinfo WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['Savior Card'] = $user['savior_card'];
        $_SESSION['Experience Points'] = $user['xp'];
        $_SESSION['Victories'] = $user['games_won'];
        $_SESSION['Defeats'] = $user['games_lost'];
        $_SESSION['Total Played Games'] = $user['games_played'];
        header("Location: protected_page.php");
        exit();
    } else {
        echo "<script>alert('Incorrect username or password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Brinth</title>
    <link rel="stylesheet" href="../brinth_styles/index/Brinth_Sin_NM_Style.css" />
    <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png" />
    <link rel="stylesheet" href="../brinth_styles/index/brinth_footer.css">
</head>

<body>
    <h1 class="login-heading">Log in<br>Here</h1>
    <div class="container">
        <div class="login-form">
            <h2>Sign In</h2>
            <form id="loginForm" action="brinthlogin.php" method="POST">
                <input type="text" name="username" placeholder="Enter Username" required>
                <input type="password" name="password" placeholder="Enter Password" required>
                <button type="submit">Login</button>
            </form>
            <p style="text-align: center; margin-top: -10px;">
                Not a member yet? <a href="brinth_register_page.php" style="color: #d6a78a; font-weight: bold; text-decoration: underline;">Register</a>
            </p>
            <p style="text-align: center; margin-top: 10px;">
                <a href="#" style="color: #c9a07f; text-decoration: underline;"onclick="openForgotForm()">Forgot Password?</a>

            </p>
        </div>
    </div>


<!-- Forgot Password Modal -->
<div class="forgot-modal" id="forgot-modal">
    <div class="forgot-box">
        <form id="forgot-form">
            <h3>Recover Password</h3>
            <input type="email" name="recovery_email" placeholder="Enter your email" required />
            <button type="submit">Send Reset Link</button>
            <button type="button" onclick="closeForgotForm()">Cancel</button>
        </form>
    </div>
</div>
<div id="login-error-popup" class="login-error-popup" style="display: none;">
    <div class="login-error-box">
        <p>Incorrect Username or Password<br><br>Please, try again.</p>
    </div>
</div>


    <a href="brinthgame.php" class="brinth-logo-floating">
        <img src="../brinth_icons/brinth_logo.png" alt="Brinth Logo">
    </a>

    <?php include 'brinth_footer.php'; ?>
<script src="Brinth_Index_Script.js" defer></script>
</body>
</html>