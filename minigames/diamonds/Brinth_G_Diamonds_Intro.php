<?php
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../index/brinthgame.php");
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Brinth Diamonds Intro</title>
    <link rel="stylesheet" href="../../brinth_styles/games/Brinth_G_Diamonds_Intro.css">
    <link rel="icon" type="image/png" href="../../brinth_icons/brinth_logo.png">
</head>

<body>
    <div class="intro-container">
        <div class="intro-frame">
            <img id="introImage" src="../../brinth_icons/diamonds/intro1.png" class="intro-main-image" alt="">
            <div class="intro-buttons">
                <button id="backBtn" onclick="prevImage()" style="display:none">Back</button>
                <button id="nextBtn" onclick="nextImage()">Next</button>
                <form id="watchedForm" method="POST" action="save_diamonds_intro.php" style="display:none">
                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                    <input type="hidden" name="game_code" value="diamonds1">
                    <button type="submit">Watched</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const images = [
            "intro1.jpg",
            "intro2.jpg",
            "intro3.jpg",
            "intro4.jpg",
            "intro5.jpg"
        ];
        let current = 0;

        function updateButtons() {
            document.getElementById("introImage").src = `../../brinth_icons/diamonds/${images[current]}`;
            document.getElementById("backBtn").style.display = current > 0 ? 'inline-block' : 'none';
            document.getElementById("nextBtn").style.display = current < images.length - 1 ? 'inline-block' : 'none';
            document.getElementById("watchedForm").style.display = current === images.length - 1 ? 'inline-block' : 'none';
        }

        function nextImage() {
            if (current < images.length - 1) {
                current++;
                updateButtons();
            }
        }

        function prevImage() {
            if (current > 0) {
                current--;
                updateButtons();
            }
        }

        updateButtons();
    </script>
</body>

</html>