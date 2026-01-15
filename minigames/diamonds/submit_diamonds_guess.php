<?php
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index/brinthgame.php");
    exit();
}

$username = $_SESSION['username'];
$game_code = $_SESSION['game_code'] ?? '';
if (!$game_code || !isset($_POST['answers'])) {
    die("Invalid submission.");
}

$answers = $_POST['answers'];

// Fetch correct answers
$stmt = $pdo->prepare("SELECT correct FROM brinth_diamonds WHERE game_code = ?");
$stmt->execute([$game_code]);
$correct_json = $stmt->fetchColumn();
if (!$correct_json) die("Game data not found.");

$correct_answers = json_decode($correct_json, true);

// Normalize both sides
$normalized_correct = [];
foreach ($correct_answers as $k => $v) {
    $normalized_correct[strtolower(trim($k))] = strtolower(trim($v));
}

$normalized_user = [];
foreach ($answers as $k => $v) {
    $normalized_user[strtolower(trim($k))] = strtolower(trim($v));
}

// Final answer check
$is_correct = $normalized_correct == $normalized_user;

// Fetch player
$stmt = $pdo->prepare("SELECT id, savior_card FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
$user_id = $user['id'];
$current_savior = $user['savior_card'];

if (!$user_id) die("User not found.");

// Apply result
if ($is_correct) {
    $xp_earned = 400;
    $bonus_xp = 0;
    $bonus_savior = 0;

    if ($game_code === 'diamonds13') {
        $bonus_xp = 1000;
        $bonus_savior = 3;
    }

    $stmt = $pdo->prepare("UPDATE playerinfo SET 
        xp = xp + ?, 
        savior_card = savior_card + ?, 
        games_played = games_played + 1, 
        games_won = games_won + 1 
        WHERE id = ?");
    $stmt->execute([$xp_earned + $bonus_xp, $bonus_savior, $user_id]);

} else {
    $stmt = $pdo->prepare("UPDATE playerinfo SET 
        savior_card = savior_card - 1, 
        games_played = games_played + 1, 
        games_lost = games_lost + 1 
        WHERE id = ?");
    $stmt->execute([$user_id]);
}

// Mark as played
$insert = $pdo->prepare("INSERT INTO played_minigames (user_id, game_code) VALUES (?, ?)");
$insert->execute([$user_id, $game_code]);

// Save result
$_SESSION['quiz_display'] = [
    'is_victory' => $is_correct,
    'xp_earned' => $is_correct ? $xp_earned : 0,
    'correct' => $is_correct ? 'Yes' : 'No',
    'total_xp' => $is_correct ? ($xp_earned + $bonus_xp) : 0,
    'savior_card' => $is_correct ? ($current_savior + $bonus_savior) : ($current_savior - 1)
];

unset($_SESSION['game_code']);

header("Location: games_results_diamonds.php?result=" . ($is_correct ? "victory" : "defeat") . "&game=$game_code");
exit();
