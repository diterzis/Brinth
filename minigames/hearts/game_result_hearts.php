<?php
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: ../../index/brinthgame.php");
    exit();
}

$username = $_SESSION['username'];
$result = $_GET['result'] ?? '';
$game_code = $_GET['game'] ?? '';

// Fetch user
$stmt = $pdo->prepare("SELECT id, xp, games_won, games_lost FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
$user_id = $user['id'];
$current_xp = $user['xp'];
$games_won = $user['games_won'];
$games_lost = $user['games_lost'];

$is_victory = ($result === 'victory');
$xp_earned = $is_victory ? 350 : 0;

// LEVEL PROGRESS
$next_level = '';
if ($is_victory) {
    preg_match('/(\d+)/', $game_code, $matches);
    $current_level = isset($matches[1]) ? intval($matches[1]) : 0;
    $has_next = $current_level < 13;

    $thresholds = [
        1 => 5000,
        2 => 5300,
        3 => 5600,
        4 => 5900,
        5 => 6200,
        6 => 6500,
        7 => 6800,
        8 => 7100,
        9 => 7400,
        10 => 7700,
        11 => 8000,
        12 => 8300,
        13 => 4600
    ];

    $next_level_num = $current_level + 1;
    if ($has_next && isset($thresholds[$next_level_num]) && $current_xp + $xp_earned >= $thresholds[$next_level_num]) {
        $next_level = "minigames/hearts/Brinth_G_hearts.php?game=hearts{$next_level_num}";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Game Results - Brinth</title>
  <link rel="stylesheet" href="../../brinth_styles/games/resultstyle.css">
  <link rel="icon" type="image/png" href="../../brinth_icons/brinth_logo.png">
</head>
<body>
  <div class="result-container">
    <?php if ($result === 'quit'): ?>
      <h1>You quit the game.</h1>
    <?php else: ?>
      <h1><?= $is_victory ? 'Victory!' : 'Defeat' ?></h1>
    <?php endif; ?>

    <div class="result-card">
      <?php if ($result === 'quit'): ?>
        <p>You quit the game, which leads to:</p>
        <p><strong>Savior Card:</strong> -1</p>
        <p><strong>New Savior Card:</strong> <?= htmlspecialchars($_GET['savior'] ?? '?') ?></p>
        <p><strong>Games Lost:</strong> +1</p>
        <p><strong>Total Games Lost:</strong> <?= $games_lost ?></p>
      <?php elseif ($is_victory): ?>
        <p><strong>XP Earned:</strong> <?= $xp_earned ?> ☆</p>
        <p><strong>Total Games Won:</strong> <?= $games_won ?></p>
        <?php
          if ($game_code === 'hearts12') {
            echo '<p><strong>Congratulations! You have completed all levels of this category!</strong></p>';
          } elseif ($next_level) {
            echo '<p><strong>Do you wish to proceed to the next level?</strong></p>';
            echo '<a href="../../' . $next_level . '" class="start-button">Play</a>';
          }
        ?>
      <?php else: ?>
        <p><strong>Unfortunately, The door you chose was incorrect.</strong><br>
        <p><strong>As a result, you end up losing a Savior Card</strong></p>
        <br><p><strong>Be careful from now on</strong><p>
        <p><strong>Total Games Lost:</strong> <?= $games_lost ?></p>
      <?php endif; ?>
    </div>

    <a href="../Brinth_B_PickGame.php" class="start-button">Back to Games</a>
  </div>
</body>
</html>
