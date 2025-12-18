<?php
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../index/brinthgame.php");
    exit();
}
if (!isset($_GET['game'])) die("Game not specified.");

$game_code = $_GET['game'];
$_SESSION['game_code'] = $game_code;
$username = $_SESSION['username'];

// Fetch user info
$stmt = $pdo->prepare("SELECT id, xp FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
$user_id = $user['id'];
$current_xp = $user['xp'];

// Έλεγχος XP για Diamonds
$xpRequirementsDiamonds = [
    'diamonds2'  => 6000,
    'diamonds3'  => 6000,
    'diamonds4'  => 6000,
    'diamonds5'  => 6000,
    'diamonds6'  => 6000,
    'diamonds7'  => 6000,
    'diamonds8'  => 6000,
    'diamonds9'  => 6000,
    'diamonds10' => 6000,
    'diamonds11' => 6000,
    'diamonds12' => 6000,
    'diamonds14' => 6500,
    'diamonds13' => 8000
];

if (isset($xpRequirementsDiamonds[$game_code]) && $current_xp < $xpRequirementsDiamonds[$game_code]) {
    header("Location: ../not_enough_xp.php");
    exit();
}


// Check if already played
$check = $pdo->prepare("SELECT 1 FROM played_minigames WHERE user_id = ? AND game_code = ?");
$check->execute([$user_id, $game_code]);
if ($check->rowCount() > 0) {
    header("Location: ../already_played.php");
    exit();
}
// Check if played watched the intro by diamonds1
$diamonds1 = $pdo->prepare("SELECT 1 FROM played_minigames WHERE user_id = ? AND game_code = 'diamonds1'");
$diamonds1->execute([$user_id]);
if ($diamonds1->rowCount() == 0) {
    header("Location: Brinth_G_Diamonds_Intro.php");
    exit();
}

// Special redirect if game is diamonds14
if ($game_code === 'diamonds14') {
    header("Location: ace_of_diamonds.php");
    exit();
}

// Fetch game data
$stmt = $pdo->prepare("SELECT * FROM brinth_diamonds WHERE game_code = ?");
$stmt->execute([$game_code]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$game) die("Game not found.");

$title = $game['title'];
$image = $game['image'];
$intro = $game['intro'];
$clues_images = json_decode($game['clues_images'], true);
$clues_texts = json_decode($game['clues_texts'], true);
$fields = json_decode($game['fields'], true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?> - Brinth</title>
    <link rel="stylesheet" href="../../brinth_styles/games/game_diamonds.css">
    <link rel="icon" type="image/png" href="../../brinth_icons/brinth_logo.png">
</head>

<body>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="quiz-container">
        <div class="quiz-frame">
            <h1><?= htmlspecialchars($title) ?></h1>
            <img src="../../brinth_icons/diamonds/<?= htmlspecialchars($image) ?>" class="main-image" alt="">
            <p class="intro"><i><?= $intro ?></i></p>
            <p class="intro"><i>Testimonies</i></p>
            <div class="clues">
                <?php foreach ($clues_images as $index => $img): ?>
                    <img src="../../brinth_icons/diamonds/<?= htmlspecialchars($img) ?>" class="clue-img" onclick="showHint(<?= $index ?>)" alt="">
                <?php endforeach; ?>
            </div>

            <form method="POST" action="submit_diamonds_guess.php">
                <div class="field-select">
                    <h2>Your Case</h2>
                    <?php foreach ($fields as $question => $options): ?>
                        <label><?= htmlspecialchars($question) ?></label>
                        <select name="answers[<?= htmlspecialchars($question) ?>]" class="styled-select" required>
                            <option value="" disabled selected>Choose...</option>
                            <?php foreach ($options as $opt): ?>
                                <option value="<?= htmlspecialchars($opt) ?>"><?= htmlspecialchars($opt) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endforeach; ?>
                </div>
                <button class="submit-btn" type="submit">Submit</button>
            </form>

            <div class="quit-button" onclick="showQuitModal()">Quit Game</div>
        </div>
    </div>

    <div id="hintModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeHint()">&times;</span>
            <p id="hintText"></p>
        </div>
    </div>

    <div id="quitModal" class="modal">
        <div class="modal-content">
            <p>If you quit this game, it will count as a defeat and use 1 savior card.</p>
            <button onclick="closeQuitModal()">Stay</button>
            <form method="POST" action="quit_game.php">
                <button type="submit" name="quit">Quit</button>
            </form>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br>
    <script>
        const hints = <?= json_encode($clues_texts) ?>;

        function showHint(index) {
            document.getElementById("hintText").innerHTML = hints[index];
            document.getElementById("hintModal").style.display = "flex";
        }

        function closeHint() {
            document.getElementById("hintModal").style.display = "none";
        }

        function showQuitModal() {
            document.getElementById("quitModal").style.display = "flex";
        }

        function closeQuitModal() {
            document.getElementById("quitModal").style.display = "none";
        }
        const GAME_CODE = "<?= $game_code ?>";
        if (GAME_CODE === "diamonds13") {
            document.querySelector('.quiz-container').style.marginTop = "250px";
            document.querySelector('.quiz-container').style.marginBottom = "250px";
        }
    </script>
</body>

</html>