<?php
/* /brinth_games/clubs_ctc.php */
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: ../../index/brinthgame.php");
    exit();
}

$game_code = $_SESSION['game_code'] ?? '';
$username   = $_SESSION['username']   ?? '';
if (!$game_code) die("No game in session.");

/* ----- basic player / duplicate-play check ------------------ */
$stmt = $pdo->prepare("SELECT id, xp FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$player = $stmt->fetch();
$user_id    = $player['id'];
$current_xp = $player['xp'];

if ($current_xp < 0) {
    header("Location: ../not_enough_xp.php");
    exit();
}

$chk = $pdo->prepare("SELECT 1 FROM played_minigames WHERE user_id=? AND game_code=?");
$chk->execute([$user_id, $game_code]);
if ($chk->rowCount()) {
    header("Location: ../already_played.php");
    exit();
}

/* ----- fetch the 5 candidate codes -------------------------- */
$q = $pdo->prepare("SELECT comb1, hint1, comb2, hint2, comb3, hint3, comb4, hint4, comb5, hint5, correct
                    FROM brinth_clubs_ctc WHERE game_code = ?");

$q->execute([$game_code]);
$data = $q->fetch(PDO::FETCH_ASSOC);
if (!$data) die("No data for $game_code");

$combos = [$data['comb1'], $data['comb2'], $data['comb3'], $data['comb4'], $data['comb5']];
$hints  = [$data['hint1'], $data['hint2'], $data['hint3'], $data['hint4'], $data['hint5']];
$correct = $data['correct'];                     // keep for JS
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= strtoupper($game_code) ?> – Brinth</title>
    <link rel="stylesheet" href="../../brinth_styles/games/game_clubs.css">
    <link rel="icon" type="image/png" href="../../brinth_icons/brinth_logo.png">
</head>

<body>
    <div class="quiz-container">
        <div class="quiz-frame">

            <h2>Select the secret 3-digit code</h2>

            <!-- the five “triple boxes” -->
            <div class="combo-layout">
                <div class="combo-left">
                    <?php for ($i = 0; $i < 2; $i++): ?>
                        <div class="combo-entry">
                            <div class="combo-box">
                                <?php foreach (str_split($combos[$i]) as $d): ?>
                                    <span class="digit"><?= htmlspecialchars($d) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <p class="combo-hint"><?= htmlspecialchars($hints[$i]) ?></p>
                        </div>
                    <?php endfor; ?>
                </div>

                <div class="combo-right">
                    <?php for ($i = 2; $i < 4; $i++): ?>
                        <div class="combo-entry">
                            <div class="combo-box">
                                <?php foreach (str_split($combos[$i]) as $d): ?>
                                    <span class="digit"><?= htmlspecialchars($d) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <p class="combo-hint"><?= htmlspecialchars($hints[$i]) ?></p>
                        </div>
                    <?php endfor; ?>
                </div>

                <div class="combo-center">
                    <div class="combo-entry">
                        <div class="combo-box">
                            <?php foreach (str_split($combos[4]) as $d): ?>
                                <span class="digit"><?= htmlspecialchars($d) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <p class="combo-hint"><?= htmlspecialchars($hints[4]) ?></p>
                    </div>
                </div>
            </div>


            <!-- user guess -->
            <form id="guessForm" onsubmit="return handleSubmit(event)">
                <label>What's the code?</label><br>
                <input type="text" id="userGuess" maxlength="3" pattern="\d{3}" required>
                <button type="submit">Submit</button>
            </form>

            <div class="quit-button" onclick="showQuitModal()">Quit Game</div>
        </div>
    </div>

    <!-- quit modal (same markup as Spades) -->
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
        const correct = "<?= $correct ?>"; // from PHP
        const gameCode = "<?= $game_code ?>";

        function showQuitModal() {
            document.getElementById('quitModal').style.display = 'flex';
        }

        function closeQuitModal() {
            document.getElementById('quitModal').style.display = 'none';
        }

        /* utility – count how many digits user guessed exist in the secret */
        function commonDigits(a, b) {
            let hits = 0;
            [...new Set(a)].forEach(d => {
                if (b.includes(d)) hits++;
            });
            return hits;
        }

        function handleSubmit(e) {
            e.preventDefault();
            const guess = document.getElementById('userGuess').value;
            if (guess.length !== 3) {
                alert("Enter exactly 3 digits");
                return false;
            }

            const matches = commonDigits(guess, correct); // 0‒3
            const exact = (guess === correct) ? 1 : 0;

            // redirect to server-side result page (updates DB there)
            window.location.href =
                `game_result_ctc.php?matches=${matches}&exact=${exact}`;
            return false;
        }
    </script>
</body>

</html>