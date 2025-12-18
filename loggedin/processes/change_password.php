<?php
session_start();
require '../brinth-database.php';

if (isset($_POST['change_pass'], $_POST['current_pass'], $_POST['new_pass'], $_POST['verify_pass'])) {
    $username = $_SESSION['username'];

    $stmt = $pdo->prepare("SELECT password_hash FROM playerinfo WHERE username = ?");
    $stmt->execute([$username]);
    $hash = $stmt->fetchColumn();

    if (password_verify($_POST['current_pass'], $hash)) {
        if ($_POST['new_pass'] === $_POST['verify_pass']) {
            $newHash = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE playerinfo SET password_hash = ? WHERE username = ?");
            $update->execute([$newHash, $username]);
            $_SESSION['message'] = "Your password was changed successfully!";
        } else {
            $_SESSION['message'] = "New passwords do not match!";
        }
    } else {
        $_SESSION['message'] = "Current password is incorrect!";
    }
}

header("Location: ../settings.php");
exit();
