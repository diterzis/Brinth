<?php
session_start();
require 'brinth-database.php';
require 'Brinth_Role_Checker.php';
require 'Brinth_Savior_Checker.php';

// check if user logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // if not, back to log in
  header("Location: ../index/brinthgame.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brinth</title>
  <link rel="stylesheet" href="../brinth_styles/inside/startpage.css">
  <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
</head>

<body>
  <div class="page-container">
    <div class="page-container">
      <img src="../brinth_icons/corner.png" class="corner corner-tl" alt="">
      <img src="../brinth_icons/corner.png" class="corner corner-tr" alt="">
      <img src="../brinth_icons/corner.png" class="corner corner-bl" alt="">
      <img src="../brinth_icons/corner.png" class="corner corner-br" alt="">

      <div class="top-frame">
        <div class="top-line"></div>

        <div class="nav-bar">
          <a href="player_info.php">Profile</a>
          <a href="brinth-leaderboard.php">Leaders</a>
          <a href="brinth_comic.php">Comic</a>
          <a href="settings.php">Settings</a>
          <a href='brinthlogout.php'>Log out</a>
        </div>

        <svg class="ornament-top" viewBox="0 0 400 40" preserveAspectRatio="none">
          <path d="M0,30 C120,0 280,0 400,30" />
        </svg>


        <div class="username">
          <span class="star star1"></span>
          <span class="star star2"></span>
          <?php echo htmlspecialchars($_SESSION['username']); ?>
        </div>
        <svg class="ornament-bottom" viewBox="0 0 400 40" preserveAspectRatio="none">
          <path d="M0,10 C120,40 280,40 400,10" />
        </svg>
        <span class="star star3"></span>
        <span class="star star4"></span>
      </div>

    </div>


    <div class="center-message">
      <p class="waiting-text">What are you waiting for?</p>
      <a href="../minigames/Brinth_B_PickGame.php" class="start-button">Start Game</a>
    </div>
    <button id="reportBtn" class="report-button">
      <img src="../brinth_icons/report_icon.png" alt="Report" width="40">
    </button>
    <div id="reportModal" class="report-modal">
      <div class="report-content">
        <textarea id="reportText" placeholder="Describe the issue..."></textarea>
        <button id="submitReport">Send Report</button>
        <button onclick="closeReport()" class="close-report">Close</button>
      </div>
    </div>
  </div>

<!-- Mobile Top Bar -->
<div class="mobile-topbar">
  <div class="menu-icon" onclick="toggleMobileNav()">☰</div>
</div>

<!-- Slide-In Mobile Menu -->
<div id="mobileSlideNav" class="mobile-slide-nav">
  <div class="menu-icon" onclick="toggleMobileNav()">☰</div>
  <nav class="mobile-slide-links">
    <a href="player_info.php">Profile</a>
    <a href="brinth-leaderboard.php">Leaders</a>
    <a href="brinth_comic.php">Comic</a>
    <a href="settings.php">Settings</a>
    <a href="brinthlogout.php">Log out</a>
  </nav>
</div>

  <script>
    document.getElementById("reportBtn").onclick = () => {
      document.getElementById("reportModal").style.display = "flex";
    };

    function closeReport() {
      document.getElementById("reportModal").style.display = "none";
    }

    document.getElementById("submitReport").onclick = () => {
      const message = document.getElementById("reportText").value;
      if (message.trim() === '') return;

      fetch('processes/submit_report.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            message
          })
        })
        .then(res => res.text())
        .then(data => {
          alert("Report submitted. Thank you!");
          document.getElementById('reportText').value = ''; // clear the textarea after usr typed 
          closeReport();
        });

    };
function toggleMobileNav() {
  const nav = document.getElementById("mobileSlideNav");
  const topbar = document.querySelector(".mobile-topbar");

  nav.classList.toggle("open");

  if (nav.classList.contains("open")) {
    topbar.style.visibility = "hidden";
  } else {
    topbar.style.visibility = "visible";
  }
};


  </script>

</body>

</html>