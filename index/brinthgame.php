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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Brinth</title>

  <link rel="stylesheet" href="../brinth_styles/index/brinth_navbar.css" />
  <link rel="stylesheet" href="../brinth_styles/index/brinth_forgot.css" />
  <link rel="stylesheet" href="../brinth_styles/index/brinth_footer.css" />
  <link rel="stylesheet" href="../brinth_styles/index/Brinth_Sin_Style.css" />
  <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap" rel="stylesheet" />
  <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png" />
</head>

<body>
<?php include 'brinth_header.php'; ?>

  <!-- Hero Section -->
  <div class="brinth-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>Brinth</h1>
      <p>Where Gaming meets Knowledge and Knowledge meets Innovation. Can you make it in time?</p>
      <a href="brinth_register_page.php" class="hero-button">PLAY NOW</a>
    </div>
  </div>


  <!-- Section 0 -->
  <div class="brinth-highlight1">
    <div class="brinth-section">
      <div class="section-text1">
        <h2>Brinth Insights</h2>
        <p>Are you ready to handle what the game has to offer you? From a simple Quiz to testing your memory and your intelligence by finding the way out.
          Here you can't simply play a game, you have to respect your Visa. Explore new level roles, earn experience point and reach the top with the best players.</p>
        <a href="Brinth_Sin_Insights.php" class="section-btn">Learn More</a>
      </div>
    </div>
  </div>
  <!-- Section 1 -->
  <div class="brinth-section">
    <div class="section-image">
      <img src="../brinth_icons/intro_image2.jpg" alt="Brinth Reveal">
    </div>
    <div class="section-text">
      <h2>Uncover the Secrets</h2>
      <p>Brinth is more than a game. It's a race against time, packed with mysterious paths, choices, and challenges. Are you ready to explore?</p>
      <a href="brinth_gamespage.php" class="section-btn">See Games</a>
    </div>

  </div>
    <!-- Section 2 -->
  <div class="brinth-highlight1-1">
    <div class="brinth-section">
      <div class="section-text1">
        <h2>The Game That Changes Everything</h2>
      <p>Each suit — Spades, Hearts, Clubs, Diamonds — was chosen with a psychological theme in mind. Hearts challenge your vision.
          Spades test logic. Clubs demand memory. Diamonds push your reaction speed. The deeper you go, the darker it gets.<br><br>Can you handle it?</p>
        <a href="all.php" class="section-btn">Learn More</a>
      </div>
    </div>
  </div>


  <!-- Section 3 -->
  <div class="brinth-section">
    <div class="section-image">
      <img src="../brinth_icons/intro_image3.jpg" alt="Leaderboard Vibes">
    </div>
    <div class="section-text">
      <h2>Join the Ranks</h2>
      <p>Climb the leaderboard, challenge others, and prove your place. Whether you're a strategist or a guesser, there's room for you in Brinth.</p>
      <a href="brinth_leaderboard.php" class="section-btn">Leaderboard</a>
    </div>
  </div>


  <hr class="brinth-divider">
<?php include 'brinth_footer.php'; ?>
<script src="Brinth_Index_Script.js" defer></script>

</body>


</html>