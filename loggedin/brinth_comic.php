<?php 
session_start();
require '../brinth-database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index/brinthgame.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brinth Comic</title>
    <link rel="stylesheet" href="../brinth_styles/inside/Brinth_Comic.css">
    <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
</head>
<body>
    <div class="comic-container">
        <div class="comic-frame">
            <img id="comicImage" src="../brinth_icons/comic/comic1.jpg" class="comic-main-image" alt="">
            <div class="comic-buttons">
                <button id="backBtn" onclick="prevImage()" style="display:none">Back</button>
                <button id="nextBtn" onclick="nextImage()">Next</button>
                <a href="../minigames/Brinth_B_PickGame.php" id="doneLink" style="display:none">
                    <button>Play Now</button>
                </a>
            </div>
        </div>
    </div>

    <script>
        const images = [
            "comic1.jpg",
            "comic2.jpg",
            "comic3.jpg",
            "comic4.jpg",
            "comic5.jpg",
            "comic6.jpg" 
        ];
        let current = 0;

        function updateComic() {
            document.getElementById("comicImage").src = `../brinth_icons/comic/${images[current]}`;
            document.getElementById("backBtn").style.display = current > 0 ? 'inline-block' : 'none';
            document.getElementById("nextBtn").style.display = current < images.length - 1 ? 'inline-block' : 'none';
            document.getElementById("doneLink").style.display = current === images.length - 1 ? 'inline-block' : 'none';
        }

        function nextImage() {
            if (current < images.length - 1) {
                current++;
                updateComic();
            }
        }

        function prevImage() {
            if (current > 0) {
                current--;
                updateComic();
            }
        }

        updateComic();
    </script>
</body>
</html>
