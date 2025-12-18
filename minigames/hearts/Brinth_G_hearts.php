<?php
session_start();
require '../../brinth-database.php';


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: ../../index/brinthgame.php");
  exit();
}

if (!isset($_GET['game'])) {
  die("Game not specified.");
}

$game_code = $_GET['game'];
$username = $_SESSION['username'];

$stmt = $pdo->prepare("SELECT id, xp, savior_card FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

$user_id = $user['id'];
$current_xp = $user['xp'];

$check = $pdo->prepare("SELECT * FROM played_minigames WHERE user_id = ? AND game_code = ?");
$check->execute([$user_id, $game_code]);
if ($check->rowCount() > 0) {
  header("Location: ../already_played.php");
  exit();
}
if ($game_code === 'hearts13') {
  header("Location: ace_of_hearts.php");
}
if ($current_xp < 6500) {
  header("Location: ../not_enough_xp.php");
  exit();
}

$game_id = intval(preg_replace('/[^0-9]/', '', $game_code));

$stmt = $pdo->prepare("SELECT * FROM brinth_hearts WHERE id = ?");
$stmt->execute([$game_id]);
$data = $stmt->fetch();

if (!$data) {
  die("Where are you going silly? The game has limits. Don't cross them");
}

$door1 = $data['door1_image'];
$door2 = $data['door2_image'];
$correct = $data['correct'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= strtoupper($game_code) ?> - Brinth</title>
  <link rel="stylesheet" href="../../brinth_styles/games/game_hearts.css">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="../../brinth_icons/brinth_logo.png">
</head>

<body>

  <div class="quiz-container">
    <div class="quiz-frame">
      <div id="quiz-content">
        <p>This is your destiny. And the last call. Pick a Door. Carefully.</p>
      </div>
    </div>
  </div>
  <div class="main-container">
    <div class="scene-image" id="scene">
      <img src="../../brinth_icons/hearts.jpg" class="background-scene" alt="Background">
      <img src="../../brinth_icons/hearts_frame1.png" class="gold-frame" alt="Frame">
      <img src="../../brinth_icons/<?= $door1 ?>.png" class="door" id="door1">
      <img src="../../brinth_icons/<?= $door2 ?>.png" class="door" id="door2">
    </div>

  </div>
  <div class="quit-container">
    <button class="quit-button" onclick="showQuitModal()">Quit Game</button>
  </div>

  <!-- Quit Modal -->
  <div id="quitModal" class="modal">
    <div class="modal-content">
      <p>If you quit this game, you will NOT be able to replay it.<br>
        It will count as a defeat and use 1 savior card.</p>
      <button onclick="closeQuitModal()">Stay In Game</button>
      <form method="POST" action="quit_game.php" style="display:inline;">
        <button type="submit" name="quit">Quit</button>
      </form>
    </div>
  </div>
  <script>
    const correctDoor = "<?= $correct ?>";
    const gameCode = "<?= $game_code ?>";

    function placeDoor(imgId, positionWord) {
      const door = document.getElementById(imgId);
      const map = {
        'left': '0%',
        'middle': '33.3333%',
        'right': '66.6666%'
      };
      //door.style.top = '35%';
      door.style.left = map[positionWord];
    }

    function extractPos(name) {
      if (name.includes('left')) return 'left';
      if (name.includes('middle')) return 'middle';
      if (name.includes('right')) return 'right';
      return '';
    }

    // Door placements
    placeDoor("door1", extractPos("<?= $door1 ?>"));
    placeDoor("door2", extractPos("<?= $door2 ?>"));

    document.getElementById("door1").onclick = () => handleClick("door1");
    document.getElementById("door2").onclick = () => handleClick("door2");

    function handleClick(selected) {
      fetch("process_hearts_game.php", {
          method: "POST",
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: "selected=" + selected + "&correct=" + correctDoor + "&game=" + gameCode
        }).then(res => res.text())
        .then(res => {
          window.location.href = 'game_result_hearts.php?result=' + res + '&game=' + gameCode;
        });
    }

    function showQuitModal() {
      document.getElementById("quitModal").style.display = "flex";
    }

    function closeQuitModal() {
      document.getElementById("quitModal").style.display = "none";
    }
  </script>
</body>

</html>