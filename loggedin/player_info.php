<?php
session_start();
require 'brinth-database.php';
require 'Brinth_Role_Checker.php';
require 'Brinth_Savior_Checker.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index/brinthgame.php");
    exit();
}

$username = $_SESSION['username'];

$stmt = $pdo->prepare("SELECT games_won, games_lost, savior_card, xp, category FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$gamesWon = $row['games_won'];
$gamesLost = $row['games_lost'];
$saviorCard = $row['savior_card'];
$totalXP = $row['xp'];
$role = ucfirst($row['category']);
$roleImageMap = [
    'Unclassified' => 'role_unclassified.png',
    'Brinther' => 'role_brinther.png',
    'First Class Brinther' => 'role_first_class_brinther.png',
    'Master Brinther' => 'role_master_brinther.png',
    'Specialist' => 'role_specialist.png',
    'Captain' => 'role_captain.png',
    'Major Brinther' => 'role_major_brinther.png',
    'Command Brinth Major' => 'role_command_brinth_major.png',
    'Leader' => 'role_leader.png'
];

$roleImageFile = isset($roleImageMap[$role]) ? $roleImageMap[$role] : 'default.png';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Player Info - Brinth</title>
  <link rel="stylesheet" href="../brinth_styles/inside/playerinfo.css">
  <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
</head>
<body>
  <div class="page-container">

    <div class="page-title">PLAYER INFO</div>
    <hr>
    <div class="top-username"><?= htmlspecialchars($username) ?></div>
    <hr>

    <div class="info-list">
      <p>Games Won: <span><?= $gamesWon ?></span></p>
      <p>Games Lost: <span><?= $gamesLost ?></span></p>
      <p>Savior Card: <span><?= $saviorCard ?></span></p>
      <p>Total XP: <span><?= $totalXP ?></span></p>
    </div>

    <div class="role-box" data-role-image="<?= htmlspecialchars($roleImageFile) ?>">
      <?= htmlspecialchars($role) ?>
      <div class="role-label"></div>
    </div>



    <div class="back-button-container">
      <a href="protected_page.php" class="start-button">Back to Main</a>
    </div>
  </div>
  <script>
  const roleBox = document.querySelector('.role-box');
  const image = roleBox.dataset.roleImage;
  const left = roleBox.querySelector('::before');
  const right = roleBox.querySelector('::after');

  //dynamic background using inline style
  const url = `../brinth_icons/${image}`;
  const style = document.createElement('style');
  style.innerHTML = `
    .role-box::before,
    .role-box::after {
      background-image: url('${url}');
    }
  `;
  document.head.appendChild(style);
</script>
</body>
</html>
