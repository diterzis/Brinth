<?php
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: ../../index/brinthgame.php");
    exit();
}

$game_code = $_SESSION['game_code'] ?? '';
$username  = $_SESSION['username'] ?? '';

if (!$game_code) die("No game in session.");

// get user id
$stmt = $pdo->prepare("SELECT id FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) die("User not found.");
$user_id = (int)$user['id'];

// prevent replay
$chk = $pdo->prepare("SELECT 1 FROM played_minigames WHERE user_id=? AND game_code=?");
$chk->execute([$user_id, $game_code]);
if ($chk->rowCount()) {
    header("Location: ../already_played.php");
    exit();
}

// get answer+hint
$q = $pdo->prepare("SELECT answer, hint FROM brinth_clubs_hangman WHERE game_code = ?");
$q->execute([$game_code]);
$row = $q->fetch(PDO::FETCH_ASSOC);
if (!$row) die("No data for $game_code");

$answer = $row['answer'];
$hint   = $row['hint'];
$_SESSION['hangman_answer'] = $answer;
$_SESSION['game_code']      = $game_code;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= strtoupper($game_code) ?> - Brinth</title>
  <link rel="stylesheet" href="../../brinth_styles/games/game_hangman.css" />
  <link rel="icon" type="image/png" href="../../brinth_icons/brinth_logo.png" />
</head>
<body>
  <div class="hangman-container">
    <div class="hangman-frame">
      <h2 class="hangman-hint">GUESS THE PHRASE</h2>
      <p class="hangman-subhint"><?= htmlspecialchars($hint) ?></p>

      <div class="hangman-graphics" id="hangmanImageContainer"
           style="background-image: url('../../brinth_icons/hangman/stage0.png');">
      </div>

      <div id="wordDisplay" class="hangman-word"></div>

      <div class="keyboard" id="keyboard"></div>

      <button class="quit-button" onclick="showQuitModal()">QUIT GAME</button>
    </div>
  </div>

  <!-- Quit Modal -->
  <div id="quitModal" class="modal">
    <div class="modal-content">
      <p>Quitting will count as a defeat and use 1 savior card.</p>
      <button onclick="closeQuitModal()">Stay</button>
      <form method="POST" action="quit_game.php" style="display:inline;">
        <button type="submit" name="quit">Quit</button>
      </form>
    </div>
  </div>

  <script>
    const ANSWER = <?= json_encode(strtoupper($answer)) ?>;
    let revealed = [];
    let wrongGuesses = 0;
    const maxWrong = 7;

    function init() {
      revealed = Array.from(ANSWER).map(c => (c === ' ' ? ' ' : '_'));
      updateWordDisplay();
      createKeyboard();
    }

    function createKeyboard() {
      const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      const container = document.getElementById('keyboard');
      letters.split('').forEach(letter => {
        const btn = document.createElement('button');
        btn.textContent = letter;
        btn.dataset.letter = letter;
        btn.onclick = () => handleGuess(letter, btn);
        container.appendChild(btn);
      });
    }

    function updateWordDisplay() {
      document.getElementById('wordDisplay').innerHTML =
        revealed.map(c => (c === ' ' ? '&nbsp;&nbsp;' : c)).join(' ');
    }

    function handleGuess(letter, button) {
      // lock this key immediately and add the visual slash
      button.disabled = true;
      button.classList.add('key-used');

      let hit = false;
      for (let i = 0; i < ANSWER.length; i++) {
        if (ANSWER[i] === letter) {
          revealed[i] = letter;
          hit = true;
        }
      }

      if (hit) {
        updateWordDisplay();
        if (revealed.join('') === ANSWER) {
          window.location.href = 'game_result_hangman.php?win=1';
        }
      } else {
        wrongGuesses++;
        document.getElementById('hangmanImageContainer').style.backgroundImage =
          `url('../../brinth_icons/hangman/stage${wrongGuesses}.png')`;
        if (wrongGuesses >= maxWrong) {
          window.location.href = 'game_result_hangman.php?win=0';
        }
      }
    }

    function showQuitModal() {
      document.getElementById("quitModal").style.display = "flex";
    }

    function closeQuitModal() {
      document.getElementById("quitModal").style.display = "none";
    }

    init();
  </script>
</body>
</html>
