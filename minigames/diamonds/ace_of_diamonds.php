<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../index/brinthgame.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ace of Diamonds - Brinth</title>
    <link rel="icon" type="image/png" href="../../brinth_icons/brinth_logo.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&display=swap');

        @font-face {
            font-family: 'Black Mustang';
            src: url('../../brinth_styles/brinth_fonts/Black Mustang.ttf') format('truetype');
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background: url("../../brinth_icons/bg6.webp") no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            overflow-x: hidden;
        }

        .page-container {
            height: 100vh;
            padding-top: 80px;
            text-align: center;
            position: relative;
        }

        .page-title {
            font-size: 3.5em;
            font-family: 'Black Mustang';
            color: #413b38ff;
            text-shadow: 1px 1px 2px #9e8170, 0 0 10px #9e8170;
            margin-bottom: 30px;
        }

        .message-paragraph {
            font-size: 1.3em;
            font-family: 'Cinzel Decorative', serif;
            color: #d5c1ad;
            text-shadow: 0 0 6px #5e4431;
            max-width: 800px;
            margin: 0 auto 60px auto;
            line-height: 1.7;
        }

        .card-container {
            perspective: 1000px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 50px;
        }

        .card {
            width: 230px;
            height: 350px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.8s;
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.05) rotateY(0deg);
        }

        .card.flipped {
            transform: rotateY(180deg);
        }

        .card-side {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 16px;
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.2);
        }

        .card-front {
            background: url('../../brinth_icons/carddiamond.webp') center/cover no-repeat;
        }

        .card-back {
            background: url('../../brinth_icons/ace_of_diamonds_hint.png') center/cover no-repeat;
            transform: rotateY(180deg);
        }

        .back-button-container {
            margin-top: 20px;
        }

        .start-button {
            display: inline-block;
            font-family: 'Attack of Monster', serif;
            padding: 40px 80px;
            font-size: 2.2em;
            color: #795845;
            background: transparent;
            border: 5px solid #795845;
            text-decoration: none;
            clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);
            box-shadow: 0 0 20px rgba(42, 20, 167, 0.4);
            transition: all 0.3s ease;
            text-shadow: 1px 1px 2px #3e2d20, 0 0 8px #a88a60;
        }

        .start-button:hover {
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 25px #fff;
            color: #fff;
        }
    </style>
    <script>
        function flipCard() {
            const card = document.querySelector('.card');
            card.classList.toggle('flipped');
        }
    </script>
</head>

<body>
    <div class="page-container">
        <div class="page-title">Ace of Diamonds</div>

        <div class="card-container">
            <div class="card" onclick="flipCard()">
                <div class="card-side card-front"></div>
                <div class="card-side card-back"></div>
            </div>
        </div>

        <div class="message-paragraph">
            The card is yours. <br>Claim your hint by clicking on the card.
        </div>

        <div class="back-button-container">
            <a href="../Brinth_B_PickGame.php" class="start-button">Back to Games</a>
        </div>
    </div>
</body>

</html>