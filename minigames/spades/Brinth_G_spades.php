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

$stmt = $pdo->prepare("SELECT id, xp FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

$user_id = $user['id'];
$current_xp = $user['xp'];

$xpRequirements = [
    'spades7'  => 800,
    'spades8'  => 800,
    'spades9'  => 1500,
    'spades10' => 1500,
    'spades11' => 2000,
    'spades12' => 2500,
    'spades13' => 3000,
    'spades14' => 3500
];

if (isset($xpRequirements[$game_code]) && $current_xp < $xpRequirements[$game_code]) {
    header("Location: ../not_enough_xp.php");
    exit();
}

$check = $pdo->prepare("SELECT * FROM played_minigames WHERE user_id = ? AND game_code = ?");
$check->execute([$user_id, $game_code]);
if ($check->rowCount() > 0) {
  header("Location: ../already_played.php");
  exit();
}
if ($game_code === 'spades14') {
  header("Location: ace_of_spades.php");
}

$stmt = $pdo->prepare("SELECT question AS q, a, b, c, d, correct, game_title FROM brinth_spades WHERE game_code = ?");
$stmt->execute([$game_code]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($questions)) {
  die("No questions found for this game.");
}
$game_title = trim($questions[0]['game_title'] ?? '');
if ($game_title === '') { $game_title = strtoupper($game_code); }

$_SESSION['quiz_questions'] = $questions;
$_SESSION['quiz_index'] = 0;
$_SESSION['game_code'] = $game_code;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= strtoupper($game_code) ?> - Brinth</title>
  <link rel="stylesheet" href="../../brinth_styles/games/game_spades.css">
  <link rel="icon" type="image/png" href="../../brinth_icons/brinth_logo.png">
</head>

<body>
  <div class="quiz-container">
    <div class="quiz-frame">
      <div id="quiz-content"></div>
      <div class="quit-button" onclick="showQuitModal()">Quit Game</div>
    </div>
  </div>

  <!-- Quit Modal -->
  <div id="quitModal" class="modal">
    <div class="modal-content">
      <p>If you quit this game, you will NOT be able to replay it.<br>It will count as a defeat and use 1 savior card.</p>
      <button onclick="closeQuitModal()">Stay In Game</button>
      <form method="POST" action="quit_game.php" style="display:inline;">
        <button type="submit" name="quit">Quit</button>
      </form>
    </div>
  </div>

  <script>
    const currentGameCode = "<?= $game_code ?>";
    const gameTitle = "<?= addslashes($game_title) ?>";
    let correctCount = 0;
    const questions = <?= json_encode($questions) ?>;
    let index = 0;

    function renderQuestion() {
      if (index >= questions.length) {
        window.location.href = 'game_result.php?correct=' + correctCount;
        return;
      }
      const q = questions[index];
      document.getElementById('quiz-content').innerHTML = `
      <h1 class="game-title">${gameTitle}</h1>
      <img src="../../brinth_icons/spades/${currentGameCode}.jpg" class="question-img" alt="">
      <h2>${q.q}</h2>
      <div class="answers">
        <button onclick="checkAnswer('a')">${q.a}</button>
        <button onclick="checkAnswer('b')">${q.b}</button>
        <button onclick="checkAnswer('c')">${q.c}</button>
        <button onclick="checkAnswer('d')">${q.d}</button>
      </div>
    `;
    }

    function checkAnswer(ans) {
      if (ans === questions[index].correct) {
        correctCount++;
      }
      index++;
      renderQuestion();
    }


    function showQuitModal() {
      document.getElementById("quitModal").style.display = "flex";
    }

    function closeQuitModal() {
      document.getElementById("quitModal").style.display = "none";
    }

    renderQuestion();
  </script>
</body>

</html>