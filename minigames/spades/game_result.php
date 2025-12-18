<?php
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: ../../index/brinthgame.php");
  exit();
}

$username = $_SESSION['username'];
$is_quit = isset($_GET['result']) && $_GET['result'] === 'quit';

if ((!isset($_SESSION['result_applied']) || isset($_GET['correct'])) && !$is_quit) {
  $_SESSION['result_applied'] = true;

  $game_code = $_SESSION['game_code'] ?? '';
  $correct = isset($_GET['correct']) ? (int)$_GET['correct'] : 0;
  $total_questions = 10;
  $xp_earned = $correct * 33;
  $is_victory = $correct >= 7;
  $bonus = $is_victory ? 100 : 0;
  $total_xp = $xp_earned + $bonus;

  $stmt = $pdo->prepare("UPDATE playerinfo SET xp = xp + ?, games_won = games_won + ?, games_lost = games_lost + ?, savior_card = savior_card - ?, games_played = games_played + 1 WHERE username = ?");
  $stmt->execute([
    $total_xp,
    $is_victory ? 1 : 0,
    $is_victory ? 0 : 1,
    $is_victory ? 0 : 1,
    $username
  ]);

  $stmt = $pdo->prepare("SELECT id FROM playerinfo WHERE username = ?");
  $stmt->execute([$username]);
  $user_id = $stmt->fetchColumn();

  $check = $pdo->prepare("SELECT * FROM played_minigames WHERE user_id = ? AND game_code = ?");
  $check->execute([$user_id, $game_code]);
  if ($check->rowCount() === 0 && $game_code) {
    $add = $pdo->prepare("INSERT INTO played_minigames (user_id, game_code) VALUES (?, ?)");
    $add->execute([$user_id, $game_code]);
  }

  $_SESSION['quiz_display'] = [
    'correct' => $correct,
    'xp_earned' => $xp_earned,
    'bonus' => $bonus,
    'total_xp' => $total_xp,
    'is_victory' => $is_victory
  ];

  unset($_SESSION['quiz_questions'], $_SESSION['quiz_index'], $_SESSION['game_code'], $_SESSION['quiz_correct']);
}

if ($is_quit) {
  $new_savior = $_GET['savior'] ?? '?';
}
$game_data = $_SESSION['quiz_display'] ?? [];
$correct = $game_data['correct'] ?? 0;
$xp_earned = $game_data['xp_earned'] ?? 0;
$bonus = $game_data['bonus'] ?? 0;
$total_xp = $game_data['total_xp'] ?? 0;
$is_victory = $game_data['is_victory'] ?? false;
$total_questions = 10;
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
    <h1>
      <?= $is_quit ? 'You quit the game.' : ($is_victory ? 'Victory!' : 'Defeat') ?>
    </h1>

    <div class="result-card">
      <?php if ($is_quit): ?>
        <p>You quit the game, which leads to:</p>
        <p><strong>Savior Card:</strong> -1</p>
        <p><strong>New Savior Card:</strong> <?= htmlspecialchars($new_savior) ?></p>
        <p><strong>Games Lost:</strong> +1</p>
      <?php else: ?>
        <p><strong>Correct Answers:</strong> <?= $correct ?>/<?= $total_questions ?> (<?= round($correct / $total_questions * 100) ?>%)</p>
        <p><strong>XP Earned:</strong> <?= $xp_earned ?>☆</p>
        <?php if ($is_victory): ?>
          <p><strong>+100 XP Bonus!</strong></p>
          <p><strong>Total XP:</strong> +<?= $total_xp ?>☆</p>
          <p><strong>Games Won:</strong> +1</p>
        <?php else: ?>
          <p><strong>Total XP:</strong> +<?= $total_xp ?>☆</p>
          <p><strong>Savior Card:</strong> -1</p>
          <p><strong>Games Lost:</strong> +1</p>
        <?php endif; ?>
      <?php endif; ?>
    </div>

    <a href="../Brinth_B_PickGame.php" class="start-button">Back to Games</a>
  </div>
</body>

</html>