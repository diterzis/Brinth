<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../loggedin/protected_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rules & Safety - Brinth</title>
    <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_navbar.css" />
    <link rel="stylesheet" href="../brinth_styles/index/brinth_forgot.css" />
    <link rel="stylesheet" href="../brinth_styles/index/brinth_footer.css" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Georgia', serif;
            background: radial-gradient(ellipse at center, #102324, #000);
            color: #f0f0f0;
            padding-top: 100px;
        }

        .page-container {
            padding: 80px 40px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .page-title {
            text-align: center;
            font-size: 3.5em;
            font-family: 'Cinzel Decorative', serif;
            color: #a0d8ef;
            text-shadow: 0 0 20px #00ffffa1;
            margin-bottom: 50px;
        }

        .rules-section {
            font-size: 1.2em;
            line-height: 1.8;
            color: #ccc;
        }

        .rules-section ul {
            padding-left: 30px;
        }

        .rules-section li {
            margin-bottom: 20px;
            text-shadow: 0 0 6px #0ff2;
        }

        .brinth-divider {
            width: 80%;
            height: 2px;
            margin: 60px auto;
            border: none;
            background: linear-gradient(to right, #00ffff10, #00ffff98, #00ffff10);
            box-shadow: 0 0 12px #00ffff44, 0 0 24px #00ffff22;
            animation: pulse-glow 3s infinite ease-in-out;
        }

        .footMenuWrap {
            display: flex;
            justify-content: center;
            gap: 200px;
            padding-bottom: 50px;
            text-align: left;
            flex-wrap: wrap;
        }

        .footMenuWrap ul {
            list-style: none;
            padding: 0;
        }

        .footMenuWrap li h5 {
            font-size: 15px;
            margin-bottom: 10px;
            color: #eee;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .footMenuWrap li a {
            color: #818181;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            transition: color 0.3s ease;
            font-size: 13px;
        }

        .footMenuWrap li a:hover {
            color: #fff;
        }

        #slogan {
            text-align: center;
            font-style: italic;
            margin-top: 30px;
            color: #aaa;
            font-size: 1em;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #555;
            font-size: 0.9em;
        }

        @keyframes pulse-glow {
            0% {
                box-shadow: 0 0 6px #00ffff22, 0 0 12px #00ffff11;
            }

            50% {
                box-shadow: 0 0 16px #00ffff66, 0 0 32px #00ffff44;
            }

            100% {
                box-shadow: 0 0 6px #00ffff22, 0 0 12px #00ffff11;
            }
        }
    </style>
</head>

<body>
    <?php include 'brinth_header.php'; ?>

    <div class="page-container">
        <div class="page-title">Rules & Safety</div>

        <div class="rules-section">
            <ul>
                <li>You cannot replay a game. Once you're gone from the specific game's page, there is no turning back.</li>
                <li>Do not share your account credentials or try to access another player’s account.</li>
                <li>Each player must play fair — using scripts, bots, or cheat extensions is forbidden.</li>
                <li>If you encounter a bug or exploit, report it immediately. Abusing it may result in bans.</li>
                <li>Protect your data: Use a strong password and never give personal info to strangers.</li>
                <li>The game is designed for challenge and fun — not stress or abuse. Play responsibly.</li>
                <li>Parents should supervise young players. This game includes fantasy imagery and logic puzzles.</li>
                <li>By registering, you agree to follow these rules and the Brinth Terms of Use.</li>
                <li>This is a game and only. So enjoy.</li>

            </ul>
        </div>
    </div>

    <hr class="brinth-divider">
    <?php include 'brinth_footer.php'; ?>
    <script src="Brinth_Index_Script.js" defer></script>
</body>

</html>