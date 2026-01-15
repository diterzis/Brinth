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
    <title>Brinth Games - Brinth</title>
    <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_navbar.css">
    <link rel="stylesheet" href="../brinth_styles/index/games_page.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_footer.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_forgot.css" />
</head>

<body>
    <?php include 'brinth_header.php'; ?>

    <div class="page-container">
        <div style="text-align: center; margin-bottom: 60px;">
            <img src="../icons/back.png" alt="" class="back-arrow" style="visibility: hidden;" />

            <span class="page-title" style="display: inline-block;">Brinth Games</span>
        </div>

        <div class="game-row">
            <div class="game-text">
                <h2>Spades 12</h2>
                Test your pop knowledge in this quick-fire quiz covering viral hits,
                music legends, and unforgettable chart moments.
                Get 7 out of 10 to win and prove you're in tune with the best.
            </div>
            <div class="game-image">
                <img src="../brinth_icons/intro_games1.jpg" alt="Spades Game">
            </div>
        </div>
        <div class="game-row">
            <div class="game-image">
                <img src="../brinth_icons/intro_games2.jpg" alt="Hearts Game">
            </div>
            <div class="game-text">
                <h2>Hearts</h2>
                Find the door on your way out. Is the door you're looking for the right one? Or is it just in your mind?
                Illusions. Prove that you're capable of reaching that category and put an end to it.
            </div>
        </div>
        <div class="game-row">
            <div class="game-text">
                <h2>Clubs 5</h2>
                | 7 | 6 | 4 | ◌ One number is correct but wrongly placed<br>
                | 5 | 0 | 3 | ◌ Two number are correct but wrongly placed<br>
                | 2 | 4 | 1 | ◌ One number is correct and well placed<br>
                | 6 | 5 | 9 | ◌ One number is correct but wrongly pladed<br>
                | 9 | 8 | 7 | ◌ Nothing is correct<br><br>
                Can you find the code with one guess? Play now.<br>
            </div>
            <div class="game-image">
                <img src="../brinth_icons/intro_games3.jpg" alt="Clubs Game">
            </div>
        </div>
        <div class="game-row">
            <div class="game-image">
                <img src="../brinth_icons/intro_games4.jpg" alt="Diamonds Game">
            </div>
            <div class="game-text">
                <h2>Diamonds 2</h2>
                Vase found broke at **:** *M<br>
                Click the Testimonies, make a research and find out who did it and why.
                <br>
                <a href="brinthgame.php" class="cta-button">Play Now</a>
            </div>
        </div>
        <hr class="brinth-divider">
    </div>
    <?php include 'brinth_footer.php'; ?>
<script src="Brinth_Index_Script.js" defer></script>

</body>

</html>