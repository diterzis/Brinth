<?php
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../index/brinthgame.php");
    exit();
}

$username = $_SESSION['username'];
$new_savior = $_GET['savior'] ?? '?';
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
    <h1>You quit the game.</h1>
    <div class="result-card">
        <p>You quit the game, which leads to:</p>
        <p><strong>Savior Card:</strong> -1</p>
        <p><strong>New Savior Card:</strong> <?= htmlspecialchars($new_savior) ?></p>
        <p><strong>Games Lost:</strong> +1</p>
    </div>
    <a href="../Brinth_B_PickGame.php" class="start-button">Back to Games</a>
  </div>
</body>
</html>
