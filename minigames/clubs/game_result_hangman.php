<?php
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: ../../index/brinthgame.php");
    exit();
}

$username   = $_SESSION['username'];
$game_code  = $_SESSION['game_code'] ?? '';
$won        = isset($_GET['win']) && $_GET['win'] == 1;

$stmt = $pdo->prepare("SELECT id FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user_id = $stmt->fetchColumn();

if ($won) {
    $stmt = $pdo->prepare("UPDATE playerinfo SET xp = xp + 350, games_won = games_won + 1, games_played = games_played + 1 WHERE username = ?");
    $stmt->execute([$username]);
} else {
    $stmt = $pdo->prepare("UPDATE playerinfo SET games_lost = games_lost + 1, games_played = games_played + 1, savior_card = savior_card - 1 WHERE username = ?");
    $stmt->execute([$username]);
}

$check = $pdo->prepare("SELECT * FROM played_minigames WHERE user_id = ? AND game_code = ?");
$check->execute([$user_id, $game_code]);
if ($check->rowCount() === 0 && $game_code) {
    $add = $pdo->prepare("INSERT INTO played_minigames (user_id, game_code) VALUES (?, ?)");
    $add->execute([$user_id, $game_code]);
}

unset($_SESSION['hangman_answer'], $_SESSION['game_code']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Game Result - Brinth</title>
    <link rel="stylesheet" href="../../brinth_styles/games/resultstyle.css">
</head>

<body>
    <div class="result-container">
        <h1><?= $won ? 'Victory!' : 'Defeat' ?></h1>
        <div class="result-card">
            <?php if ($won): ?>
                <p><strong>Word Guessed Correctly!</strong></p>
                <p><strong>XP Earned:</strong> +350☆</p>
                <p><strong>Games Won:</strong> +1</p>
            <?php else: ?>
                <p><strong>Failed to guess the word.</strong></p>
                <p><strong>Savior Card:</strong> -1</p>
                <p><strong>Games Lost:</strong> +1</p>
            <?php endif; ?>
        </div>
        <a href="../Brinth_B_PickGame.php" class="start-button">Back to Games</a>
    </div>
</body>

</html>