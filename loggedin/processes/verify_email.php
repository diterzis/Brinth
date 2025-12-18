<?php
session_start();
require '../brinth-database.php';

if (!isset($_SESSION['username']) || !isset($_POST['code'])) {
    header("Location: ../settings.php");
    exit();
}

if ($_POST['code'] == $_SESSION['email_code']) {
    $stmt = $pdo->prepare("UPDATE playerinfo SET email_ver = 'Verified' WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    unset($_SESSION['email_code']);
    $_SESSION['message'] = "Email verified successfully!";
} else {
    $_SESSION['message'] = "The 5-digit code you entered is invalid. Try again.";
}

header("Location: ../settings.php");
exit();
