<?php
session_start();
require '../../brinth-database.php';

$username = $_SESSION['username'];
$game_code = $_SESSION['game_code'] ?? '';

$stmt = $pdo->prepare("UPDATE playerinfo SET savior_card = savior_card - 1, games_lost = games_lost + 1 WHERE username = ?");
$stmt->execute([$username]);

$stmt = $pdo->prepare("SELECT id, savior_card FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
$user_id = $user['id'];
$current_savior = $user['savior_card'];

$insert = $pdo->prepare("INSERT INTO played_minigames (user_id, game_code) VALUES (?, ?)");
$insert->execute([$user_id, $game_code]);

unset($_SESSION['quiz_questions'], $_SESSION['quiz_index'], $_SESSION['quiz_correct'], $_SESSION['game_code']);
header("Location: game_result_hearts.php?result=quit&game=$game_code&savior=$current_savior");
exit();
