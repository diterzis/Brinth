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
    <title>Credits - Brinth</title>
    <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_footer.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_navbar.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_forgot.css" />


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background: radial-gradient(ellipse at center, #1b0f08, #000);
            color: #f5e4d0;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            padding: 80px 20px 60px 20px;
            max-width: 900px;
            margin: auto;
            text-align: center;
        }

        h1 {
            font-family: 'Cinzel Decorative', serif;
            font-size: 3.5em;
            color: #e2ba99;
            text-shadow: 0 0 15px #6e4d37;
            margin-bottom: 50px;
        }

        .credit-section {
            margin-bottom: 50px;
            background: rgba(30, 18, 10, 0.85);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px #3c2415;
            border: 1px solid #5c3b2a;
        }

        .credit-section h2 {
            font-family: 'Cinzel Decorative', serif;
            color: #d6a78a;
            margin-bottom: 15px;
            font-size: 1.8em;
        }

        .credit-section p {
            font-size: 1.1em;
            color: #f5e4d0;
            margin: 10px 0;
        }

        .back-button {
            display: inline-block;
            margin-top: 40px;
            padding: 12px 28px;
            font-size: 1em;
            color: #fff;
            background: linear-gradient(to right, #6a4425, #8b5e3c);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .back-button:hover {
            background: linear-gradient(to right, #9a6b4a, #c68861);
        }
    </style>
</head>
<body>

<?php include 'brinth_header.php'; ?>

<main>
    <h1>Brinth Credits</h1>

    <div class="credit-section">
        <h2>Created By</h2>
        <p>Terzis Dimitrios</p>
        <p>Undergradute Student<!--, Game Designer, Developer & Writer--></p>
    </div>

    <div class="credit-section">
        <h2>Special Thanks</h2>
        <p>V. Koutsonikola, Friends, testers, and supporters of Brinth</p>
        <p>To those who believed in magic from the very beginning</p>
    </div>

    <div class="credit-section">
        <h2>Built With</h2>
        <p>Backend</p>
        <p>PHP, MySQL, PDO</p>
        <br>
        <p>Frontend</p>
        <p>HTML5, CSS3,<p></p>JavaScript, AJAX, Google Fonts</p>
        <br>
        <p>Fonts:</p>
        <p>Cinzel Decorative</p>
        <p>Attack of Monster</p>
        <p>Georgia</p>
        <p>BLKCHCRY</p>
        <p>Black Mustang</p>
        <p>CopperplateCC_Bold</p>
        <p>Vampire Wars</p>
        <br>
        <p>Tools:</p> 
        <p>Photoshop</p>
        <p>OpenAI</p>
        <p>Krita</p>
        <br>
        <p>With the help of:</p>
        <p>Visual Studio Code</p>
        <p>MySQL Workbench 8.0 CE</p>
        <p>XAMPP Control Panel</p>
        <p>Mail - Gmail - Google</p>
    </div>

    <div class="credit-section">
        <h2>Inspiration</h2>
        <p>Alice in Borderland</p>
        <p>Pinterest</p>
        <p>Riot Games</p><p>Dark fantasy & Mystery</p><p>Logic games & Storytelling</p><p>Timeless tales</p>
    </div>

<!--    <div class="credit-section">
        <h2>-</h2>
        <p>-</p>
    </div>-->

    <a href="brinthgame.php" class="back-button">Back to Main</a>
</main>

<?php include 'brinth_footer.php'; ?>
<script src="Brinth_Index_Script.js" defer></script>
</body>
</html>
