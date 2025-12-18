<?php
/* /brinth_games/game_result_ctc.php
   Server-side XP + stats update (one-shot, like game_result.php) */
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
  header("Location: ../../index/brinthgame.php");
  exit();
}

$username   = $_SESSION['username'];
$game_code  = $_SESSION['game_code'] ?? '';
$matches    = intval($_GET['matches'] ?? -1); // 0-3
$exact      = intval($_GET['exact']   ?? 0);  // 0/1

if ($matches === -1 || !$game_code) die("Bad parameters.");

$xp = 0;
switch ($matches) {
  case 1:
    $xp = 100;
    break;
  case 2:
    $xp = 200;
    break;
  case 3:
    $xp = 350;
    break;  // same even if exact=0
}

/* --------- apply playerinfo updates ------------------------ */
$won        = ($exact === 1);
$lost       = $won ? 0 : 1;
$saviorUse  = $won ? 0 : 1;

$stmt = $pdo->prepare(
  "UPDATE playerinfo
     SET xp          = xp + ?,
         games_won   = games_won   + ?,
         games_lost  = games_lost  + ?,
         games_played= games_played+ 1,
         savior_card = savior_card - ?
   WHERE username = ?"
);
$stmt->execute([$xp, $won, $lost, $saviorUse, $username]);

/* --------- mark as played ---------------------------------- */
$stmt = $pdo->prepare("SELECT id FROM playerinfo WHERE username=?");
$stmt->execute([$username]);
$user_id = $stmt->fetchColumn();

$chk = $pdo->prepare("SELECT 1 FROM played_minigames WHERE user_id=? AND game_code=?");
$chk->execute([$user_id, $game_code]);
if (!$chk->rowCount()) {
  $add = $pdo->prepare("INSERT INTO played_minigames (user_id,game_code)
                          VALUES (?,?)");
  $add->execute([$user_id, $game_code]);
}

/* --------- display ----------------------------------------- */
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Game Results – Brinth</title>
  <link rel="stylesheet" href="../../brinth_styles/games/resultstyle.css">
  <link rel="icon" type="image/png" href="../../brinth_icons/brinth_logo.png">
</head>

<body>
  <div class="result-container">
    <h1><?= $won ? 'Victory!' : 'Defeat' ?></h1>
    <div class="result-card">
      <p><strong>You guessed:</strong> <?= $matches ?>/3 digits correctly.</p>
      <p><strong>XP Earned:</strong> +<?= $xp ?>☆</p>

      <?php if ($won): ?>
        <p><strong>Games Won:</strong> +1</p>
      <?php else: ?>
        <p><strong>Savior Card:</strong> -1</p>
        <p><strong>Games Lost:</strong> +1</p>
      <?php endif; ?>
    </div>
    <a href="../Brinth_B_PickGame.php" class="start-button">Back to Games</a>
  </div>
</body>

</html>