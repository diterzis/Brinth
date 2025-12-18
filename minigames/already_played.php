<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index/brinthgame.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Game Cannot be Replayed - Brinth</title>
  <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&display=swap');

    @font-face {
      font-family: 'CopperplateCC-Bold';
      src: url('../brinth_styles/brinth_fonts/CopperplateCC-Bold.ttf') format('truetype');
    }
    body {
      margin: 0;
      padding: 0;
      font-family: 'Georgia', serif;
      background: url("../brinth_icons/bg3.jpg") no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      overflow-x: hidden;
    }

    .page-container {
      height: 100vh;
      padding-top: 40px;
      text-align: center;
      position: relative;
    }

    .page-title {
      font-size: 3em;
      font-family: 'CopperplateCC-Bold';
      color: #9e8170;
      text-shadow: 1px 1px 2px #16100b, 0 0 8px #241604;
      margin: 5px auto;
    }

    .message-box {
      margin: 40px auto;
      padding: 40px 100px;
      font-size: 1.2em;
      font-family: 'Cinzel Decorative', serif;
      color: #ddd;
      border: 3px double #795845;
      border-radius: 10px;
      width: 60%;
      background: rgba(0, 0, 0, 0.5);
      text-shadow: 1px 1px 2px #3e2d20, 0 0 8px #a88a60;
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

    hr {
      width: 50%;
      margin: 40px auto;
      border-color: #795845;
      opacity: 1;
    }
  </style>
</head>
<body>
  <div class="page-container">
    <div class="page-title">Game Cannot be Replayed</div>
    <div class="message-box">
      <p>We really appreciate the fact that you enjoyed the game so much that you'd like to re-play it. <br><br>
        Or you just hit the wrong button.<br><br>Silly..<br><br>
        If you have read the rules,<br> you should know that a game that has been played,<br> cannot be replayed. </p>
    </div>

    <div class="back-button-container">
      <a href="Brinth_B_PickGame.php" class="start-button">Back</a>
    </div>
  </div>
</body>
</html>
