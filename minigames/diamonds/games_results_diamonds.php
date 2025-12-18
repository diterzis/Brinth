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

$stmt = $pdo->prepare("SELECT id, savior_card, games_won, games_lost FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

$user_id = $user['id'];
$savior = $user['savior_card'];
$games_won = $user['games_won'];
$games_lost = $user['games_lost'];

$is_victory = ($result === 'victory');
$game_number = intval(preg_replace('/\D/', '', $game_code));

// Fetch solution from brinth_diamonds
$stmt = $pdo->prepare("SELECT solution FROM brinth_diamonds WHERE game_code = ?");
$stmt->execute([$game_code]);
$solution = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Diamonds Result - Brinth</title>
    <link rel="stylesheet" href="../../brinth_styles/games/resultstyle_diamonds.css">
    <link rel="icon" type="image/png" href="../../brinth_icons/brinth_logo.png">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background: url("../../brinth_icons/bg5.webp") no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            text-align: center;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .result-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            gap: 30px;
            z-index: 2;
            padding-bottom: 100px;
        }

        h1 {
            font-size: 3em;
            color: #795845;
            text-shadow: 0 0 10px #a88a60;
        }

        .result-card {
            display: inline-block;
            background: rgba(0, 0, 0, 0.5);
            padding: 30px 60px;
            margin-top: 40px;
            border: 2px solid #795845;
            border-radius: 20px;
            font-size: 1.2em;
            text-align: center;
            box-shadow: 0 0 15px #5e4431;
        }

        .result-card p {
            margin: 15px 0;
        }

        .start-button {
            display: inline-block;
            margin: 20px;
            padding: 15px 50px;
            font-size: 1.3em;
            border: 1.5px solid #795845;
            background: transparent;
            color: #795845;
            font-family: 'Cinzel Decorative', serif;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 15px;
        }

        .start-button:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            box-shadow: 0 0 20px #a88a60;
        }

        .completed-box {
            background: rgba(0, 0, 0, 0.6);
            border: 2px solid gold;
            padding: 20px;
            margin-top: 20px;
            border-radius: 15px;
            text-align: center;
            color: white;
            font-size: 1.1em;
        }

        .sparkle {
            position: absolute;
            width: 5px;
            height: 5px;
            background: silver;
            border-radius: 50%;
            animation: sparkleMove 6s linear infinite;
            opacity: 0.8;
        }

        .main-image {
            width: 100%;
            max-width: 750px;
            border-radius: 15px;
            margin: 20px 0;
            box-shadow: 0 0 10px #5d3e2d;
        }

        @keyframes sparkleMove {
            0% { transform: translateY(0) scale(1); opacity: 1; }
            100% { transform: translateY(-100vh) scale(0.5); opacity: 0; }
        }
    </style>
</head>

<body>
    <div class="result-container">
        <h1><?= $is_victory ? 'VICTORY!' : 'DEFEAT' ?></h1>
        <div class="result-card">
            <?php if ($is_victory): ?>
                <p><strong>Yes!</strong><br><?= $solution ?></p>

                <!-- Always show base XP -->
                <p><strong>XP Earned:</strong> +400</p>

                <!-- Extra messages for diamonds13 -->
                <?php if ($game_code === 'diamonds13'): ?>
                    <p><em>Congratulations! You have triumphed and solved the great Diamonds mystery.</em></p>
                    <p><strong>Bonus XP:</strong> +1000</p>
                    <p><strong>Extra Bonus</strong> +3 Savior Cards — enjoy!</p>
                <?php endif; ?>

                <?php if ($game_code !== 'diamonds13'): ?>
                    <a href="Brinth_G_diamonds.php?game=diamonds<?= $game_number + 1 ?>" class="start-button">Next Level?</a>
                <?php endif; ?>
                <a href="../Brinth_B_PickGame.php" class="start-button">Back to Games</a>
            <?php else: ?>
                <p><strong>Unfortunately no..</strong><br><?= $solution ?></p>
                <p><strong>Savior Card:</strong> -1</p>
                <p><strong>New Savior Card:</strong> <?= $savior ?></p>
                <p><strong>Games Lost:</strong> +1</p>
                <a href="../Brinth_B_PickGame.php" class="start-button">Back to Games</a>
            <?php endif; ?>
        </div>
    </div>

    <?php for ($i = 0; $i < 50; $i++): ?>
        <div class="sparkle" style="
            left: <?= rand(0, 100) ?>vw;
            top: <?= rand(0, 100) ?>vh;
            animation-delay: <?= rand(0, 5000) / 1000 ?>s;"></div>
    <?php endfor; ?>
</body>
</html>
