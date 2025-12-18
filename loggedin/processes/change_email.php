<?php
session_start();
require '../brinth-database.php';

if (isset($_POST['change_email'], $_POST['new_email'], $_SESSION['username'])) {
    $email = $_POST['new_email'];

    $stmt = $pdo->prepare("UPDATE playerinfo SET email = ?, email_ver = 'Not Verified' WHERE username = ?");
    $stmt->execute([$email, $_SESSION['username']]);

    $_SESSION['message'] = "Email updated! Please verify your new email.";
}

header("Location: ../settings.php");
exit();
