<?php
session_start();
require 'brinth-database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: ../index/brinthgame.php");
  exit();
}

$username = $_SESSION['username'] ?? null;
$stmt = $pdo->prepare("SELECT category FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$currentDbRole = $row['category'] ?? 'Unclassified';

/* Roles supplied by checkUserRole() */
$oldRole = $_SESSION['promo_old_role'] ?? $currentDbRole;
$newRole = $_SESSION['promo_new_role'] ?? $currentDbRole;
unset($_SESSION['promo_old_role'], $_SESSION['promo_new_role']);

$iconMap = [
  'Unclassified'           => 'role_unclassified',
  'Brinther'               => 'role_brinther',
  'First Class Brinther'   => 'role_first_class_brinther',
  'Master Brinther'        => 'role_master_brinther',
  'Specialist'             => 'role_specialist',
  'Captain'                => 'role_captain',
  'Major Brinther'         => 'role_major_brinther',
  'Command Brinth Major'   => 'role_command_brinth_major',
  'Leader'                 => 'role_leader'
];

$iconFilenameOld = ($iconMap[$oldRole] ?? 'level1') . '.png';
$iconFilenameNew = ($iconMap[$newRole] ?? 'level1') . '.png';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Promotion - Brinth</title>
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
      background: url("../brinth_icons/bg3.webp") no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      overflow-x: hidden;
    }

    /* Whole page is a button */
    .page-container {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      /* center vertically */
      align-items: center;
      /* center horizontally */
      cursor: pointer;
      text-align: center;
    }

    .text-wrap {
      width: 100%;
      display: none;
      text-align: center;
      margin-top: 40px;
      /* ⬅ adjust this value to taste */
    }


    /* Icon stage: fixed height so nothing jumps; icons absolutely centered */
    .role-stage {
      position: relative;
      width: 100%;
      height: 54vh;
      /* the “hero” area */
      max-height: 720px;
      min-height: 360px;
      overflow: visible;
    }

    .role-icon {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) scale(1);
      max-width: min(400px, 80vw);
      height: auto;
      display: block;
      filter: drop-shadow(0 0 10px rgba(0, 0, 0, .6));
    }

    .role-old {
      z-index: 1;
      opacity: 1;
    }

    .role-new {
      z-index: 2;
      opacity: 0;
      transform: translate(-50%, -50%) scale(.94);
      filter: blur(6px);
      pointer-events: none;
    }

    /* FX layers */
    .fx-flash,
    .fx-radial,
    .fx-shockwave,
    .fx-rays {
      position: absolute;
      inset: 0;
      pointer-events: none;
    }

    .fx-radial {
      z-index: 0;
      background: radial-gradient(60% 60% at 50% 50%, rgba(255, 255, 255, .06), rgba(168, 138, 96, .12) 45%, rgba(0, 0, 0, 0) 75%);
      filter: blur(10px);
      opacity: 0;
      animation: radialIn 1200ms ease forwards 400ms;
    }

    .fx-flash {
      z-index: 3;
      background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, .95), rgba(255, 255, 255, .6) 20%, rgba(255, 255, 255, 0) 60%);
      mix-blend-mode: screen;
      opacity: 0;
    }

    .fx-shockwave {
      z-index: 4;
      display: grid;
      place-items: center;
      opacity: 0;
    }

    .fx-shockwave::before {
      content: "";
      width: 40px;
      height: 40px;
      border-radius: 999px;
      border: 2px solid rgba(255, 255, 255, .85);
      box-shadow: 0 0 25px rgba(255, 255, 255, .85), 0 0 60px rgba(168, 138, 96, .6);
      opacity: 1;
      transform: scale(0);
    }

    .fx-rays {
      z-index: 1;
      opacity: 0;
      background: conic-gradient(from 0deg,
          rgba(255, 255, 255, 0), rgba(255, 255, 255, .12) 8%, rgba(255, 255, 255, 0) 18%,
          rgba(255, 255, 255, .10) 26%, rgba(255, 255, 255, 0) 36%,
          rgba(255, 255, 255, .08) 44%, rgba(255, 255, 255, 0) 54%,
          rgba(255, 255, 255, .06) 62%, rgba(255, 255, 255, 0) 72%,
          rgba(255, 255, 255, .10) 80%, rgba(255, 255, 255, 0) 100%);
      mask-image: radial-gradient(60% 60% at 50% 50%, black 30%, transparent 75%);
      mix-blend-mode: screen;
      filter: blur(2px);
    }

    /* Text area (hidden at first so stage is the only thing on screen) */
    .text-wrap {
      width: 100%;
      display: none;
      text-align: center;
    }

    .page-title {
      font-size: 3em;
      font-family: 'CopperplateCC-Bold';
      color: #9e8170;
      text-shadow: 1px 1px 2px #16100b, 0 0 8px #241604;
      margin: 5px auto 10px;
      opacity: 0;
      transform: translateY(-8px);
    }

    .sub-title,
    .reward-message,
    .keep-playing {
      opacity: 0;
      transform: translateY(8px);
    }

    .sub-title {
      font-size: 2em;
      font-family: 'Cinzel Decorative', serif;
      color: #795845;
      text-shadow: 0 0 6px #a88a60;
      margin-top: 8px;
      text-align: center;
    }

    .reward-message {
      font-size: .9em;
      font-family: 'Cinzel Decorative', serif;
      color: #cbb89f;
      margin-top: 8px;
      text-shadow: 0 0 6px #a88a60;
      text-align: center;
    }

    .keep-playing {
      font-size: 1em;
      font-family: 'Cinzel Decorative', serif;
      color: #ddd;
      margin-top: 12px;
      text-align: center;
    }

    /* Animations */
    @keyframes fadeDown {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes newReveal {
      0% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(.94);
        filter: blur(6px);
      }

      60% {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1.02);
        filter: blur(0) drop-shadow(0 0 26px rgba(168, 138, 96, .6));
      }

      100% {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
        filter: blur(0) drop-shadow(0 0 16px rgba(168, 138, 96, .5));
      }
    }

    @keyframes oldVanish {
      0% {
        opacity: 1;
        filter: blur(0);
      }

      100% {
        opacity: 0;
        filter: blur(10px);
      }
    }

    @keyframes flashBang {
      0% {
        opacity: 0;
      }

      10% {
        opacity: 1;
      }

      60% {
        opacity: .35;
      }

      100% {
        opacity: 0;
      }
    }

    @keyframes shockwave {
      0% {
        opacity: 1;
      }

      100% {
        opacity: 0;
      }
    }

    @keyframes ringExpand {
      0% {
        transform: scale(0);
        opacity: 1;
      }

      60% {
        transform: scale(9);
        opacity: .9;
      }

      100% {
        transform: scale(14);
        opacity: 0;
      }
    }

    @keyframes raysIn {
      0% {
        opacity: 0;
        transform: rotate(0deg) scale(.98);
      }

      100% {
        opacity: 1;
        transform: rotate(360deg) scale(1);
      }
    }

    @keyframes radialIn {
      to {
        opacity: 1;
      }
    }

    @keyframes riseIn {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Play state */
    .play .fx-flash {
      animation: flashBang 700ms ease-out forwards 300ms;
    }

    .play .fx-rays {
      animation: raysIn 1400ms ease-out forwards 150ms;
    }

    .play .fx-shockwave {
      animation: shockwave 1000ms ease-out forwards 500ms;
    }

    .play .fx-shockwave::before {
      animation: ringExpand 1000ms cubic-bezier(.25, .8, .25, 1) forwards 500ms;
    }

    .swap .role-old {
      animation: oldVanish 700ms ease-out forwards 0ms;
    }

    .swap .role-new {
      animation: newReveal 900ms cubic-bezier(.2, .9, .2, 1) forwards 120ms;
    }

    .show-text .page-title {
      animation: fadeDown 700ms ease forwards;
    }

    .show-text .sub-title {
      animation: riseIn 500ms ease forwards 120ms;
    }

    .show-text .reward-message {
      animation: riseIn 500ms ease forwards 240ms;
    }

    .show-text .keep-playing {
      animation: riseIn 500ms ease forwards 360ms;
    }

    @media (prefers-reduced-motion: reduce) {
      * {
        animation: none !important;
        transition: none !important;
      }

      .role-new {
        opacity: 1 !important;
        transform: translate(-50%, -50%) !important;
        filter: none !important;
      }

      .role-old,
      .fx-flash,
      .fx-shockwave,
      .fx-rays {
        display: none !important;
      }

      .text-wrap {
        display: block !important;
      }

      .page-title,
      .sub-title,
      .reward-message,
      .keep-playing {
        opacity: 1 !important;
        transform: none !important;
      }
    }
  </style>
</head>

<body>
  <div class="page-container" id="pageBtn" aria-label="Continue">
    <!-- STAGE: only icons/FX here; no text at first -->
    <div class="role-stage" id="roleStage">
      <div class="fx-radial"></div>

      <!-- Old role (visible first) -->
      <img src="../brinth_icons/<?= htmlspecialchars($iconFilenameOld) ?>"
        alt="Old Role Icon"
        class="role-icon role-old" id="oldIcon">

      <!-- New role (revealed later) -->
      <img src="../brinth_icons/<?= htmlspecialchars($iconFilenameNew) ?>"
        alt="New Role Icon"
        class="role-icon role-new" id="newIcon">

      <div class="fx-rays"></div>
      <div class="fx-flash"></div>
      <div class="fx-shockwave"></div>
    </div>

    <!-- TEXT: hidden until the icon swap is complete -->
    <div class="text-wrap" id="textWrap">
      <div class="page-title">CONGRATULATIONS</div>
      <div class="sub-title">You've been promoted to: <?= htmlspecialchars($newRole) ?></div>
      <div class="reward-message">As a token of your rising power, you’ve been granted <strong>+1 Savior Card</strong>!</div>
      <div class="keep-playing">Keep playing to reach the top!</div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const stage = document.getElementById('roleStage');
      const oldIcon = document.getElementById('oldIcon');
      const textWrap = document.getElementById('textWrap');
      const pageBtn = document.getElementById('pageBtn');

      // 1) Start subtle background FX (optional)
      stage.classList.add('play');

      // 2) Wait ~2s showing ONLY the old icon
      setTimeout(() => {
        // 3) Swap to new icon (play both fade-out & reveal)
        stage.classList.add('swap');
      }, 2000);

      // 3b) After old icon finishes fading, remove it entirely
      oldIcon.addEventListener('animationend', (e) => {
        if (e.animationName === 'oldVanish') {
          oldIcon.remove();
          // 4) Show texts shortly after the swap
          setTimeout(() => {
            textWrap.style.display = 'block';
            document.body.classList.add('show-text');
          }, 250); // slight delay feels nicer
        }
      });

      // Whole page click → home
      const goHome = () => {
        window.location.href = 'protected_page.php';
      };
      pageBtn.addEventListener('click', goHome);
      pageBtn.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          goHome();
        }
      });
    });
  </script>
</body>

</html>