<?php
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index/brinthgame.php");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
$game_code = 'diamonds1';
$redirect_game = $_SESSION['game_code'] ?? null;

if ($user_id && $redirect_game) {
    $check = $pdo->prepare("SELECT 1 FROM played_minigames WHERE user_id = ? AND game_code = ?");
    $check->execute([$user_id, $game_code]);

    if ($check->rowCount() === 0) {
        $insert = $pdo->prepare("INSERT INTO played_minigames (user_id, game_code) VALUES (?, ?)");
        $insert->execute([$user_id, $game_code]);
    }

    header("Location: Brinth_G_Diamonds.php?game=$redirect_game");
    exit();
} else {
    echo "Error: User not identified or game not set.";
    exit();
}
?>