<?php
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    exit("unauthorized");
}

$username = $_SESSION['username'];
$selected = $_POST['selected'] ?? '';
$correct = $_POST['correct'] ?? '';
$game_code = $_POST['game'] ?? '';

$stmt = $pdo->prepare("SELECT id, xp, savior_card FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

$user_id = $user['id'];
$current_xp = $user['xp'];
$savior = $user['savior_card'];

$is_correct = $selected === $correct;

if ($is_correct) {
    $new_xp = $current_xp + 350;
    $pdo->prepare("UPDATE playerinfo SET xp = ?, games_won = games_won + 1, games_played = games_played + 1 WHERE id = ?")->execute([$new_xp, $user_id]);
} else {
    $new_savior = max(0, $savior - 1);
    $pdo->prepare("UPDATE playerinfo SET savior_card = ?, games_lost = games_lost + 1, games_played = games_played + 1 WHERE id = ?")->execute([$new_savior, $user_id]);
}

// Mark game as played
$insert = $pdo->prepare("INSERT INTO played_minigames (user_id, game_code) VALUES (?, ?)");
$insert->execute([$user_id, $game_code]);

echo $is_correct ? "victory" : "defeat";
