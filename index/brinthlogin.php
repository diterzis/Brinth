<?php
require 'brinth-database.php';
require '../loggedin/Brinth_Savior_Checker.php';
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: protected_page.php");
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
        $_SESSION['Class'] = $user['category'];
        header("Location: ../loggedin/protected_page.php");
        exit();
    } else {
        $referer = $_SERVER['HTTP_REFERER'] ?? 'brinthgame.php';
        $separator = parse_url($referer, PHP_URL_QUERY) ? '&' : '?';
        header("Location: " . $referer . $separator . "login_error=1");
        exit();
    }
}
header("Location: brinthgame.php?error=1");
echo "Login Failed. Try again.";

exit();
