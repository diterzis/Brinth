<?php 
session_start();
require '../brinth-database.php';
require '../loggedin/Brinth_Savior_Checker.php';
// check if user logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // if not, back to log in
    header("Location: ../index/brinthgame.php");
    exit();
}
$username = $_SESSION['username'];


$stmt = $pdo->prepare("SELECT xp FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$xp = $row['xp'] ?? 0;
$played_games = $row['played_minigames'] ?? '';
$playedGamesArray = explode(',', $played_games);
?>
<script>
  const USER_XP = <?= $xp ?>;
  const PLAYED_GAMES = <?= json_encode($playedGamesArray) ?>;
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brinth - Category</title>
    <link rel="stylesheet" href="../brinth_styles/inside/pick.css">
    <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
</head>
<body>
<div class="page-container">
  <img src="../brinth_icons/corner.png" class="corner corner-tl" alt="">
  <img src="../brinth_icons/corner.png" class="corner corner-tr" alt="">
  <img src="../brinth_icons/corner.png" class="corner corner-bl" alt="">
  <img src="../brinth_icons/corner.png" class="corner corner-br" alt="">


<!-- CATEGORY CARDS (CLICK TO OPEN MODAL) -->
<div class="card-grid">
  <div class="category-title">Choose a Category</div>

  <div class="card" onclick="openModal('spades')">
    <img src="../brinth_icons/cardspade.webp" alt="Spades">
  </div>
  <div class="card" onclick="openModal('diamonds')">
    <img src="../brinth_icons/carddiamond.webp" alt="Diamonds">
  </div>
  <div class="card" onclick="openModal('clubs')">
    <img src="../brinth_icons/cardclub.webp" alt="Clubs">
  </div>
  <div class="card" onclick="openModal('hearts')">
    <img src="../brinth_icons/cardheart.webp" alt="Hearts">
  </div>
</div>

<!-- MODAL OVERLAY -->
<div id="cardModal" class="modal-overlay">
  <div class="modal-window">
    <div class="cards-wrapper" id="modalCards">
      <!-- Cards injected via JavaScript -->
    </div>
    <button class="close-button" onclick="closeModal()">Close Window</button>
  </div>
</div>


  <div class="center-message">
  <a href="../loggedin/protected_page.php" class="start-button">Back</a>
  </div>
</div>
<script>
function openModal(category) {
  const modal = document.getElementById('cardModal');
  const cardContainer = document.getElementById('modalCards');
  cardContainer.innerHTML = '';

  const limits = {
    spades:    [ [1, 5, 0], [6, 7, 800], [8, 9, 1500], [10, 10, 2000], [11, 11, 2500], [12, 12, 3000], [13, 13, 3500] ],
    clubs:      [ [1, 5, 0], [6, 7, 800], [8, 9, 1500], [10, 10, 2000], [11, 11, 2500], [12, 12, 3000], [13, 13, 3500]  ],
    diamonds:  [ [1, 11, 6000], [12, 12, 8000], [13, 13, 6500] ],
    hearts:    [ [1, 6, 6500], [7, 10, 7500], [11, 12, 7800], [13, 13, 8500]]
  };

  let allowed = new Set();
  for (let range of limits[category]) {
    const [start, end, minXP] = range;
    if (USER_XP >= minXP) {
      for (let i = start; i <= end; i++) allowed.add(i);
    }
  }

  for (let i = 1; i <= 13; i++) {
    const img = document.createElement('img');
    img.src = `../brinth_icons/cards/${category}/${category}image${i}.webp`;
    img.classList.add('modal-card');

    const gameID = `${category}${i}`;
    const isAllowed = allowed.has(i);
    const isPlayed = PLAYED_GAMES.includes(gameID);

    if (isAllowed && !isPlayed) {
      if (category === 'spades') {
        img.onclick = () => {
        window.location.href = `spades/Brinth_G_spades.php?game=${category}${i+1}`;
    };
  } else if (category === 'hearts') {
    img.onclick = () => {
      window.location.href = `hearts/Brinth_G_hearts.php?game=${category}${i}`;
    };
    } else if (category === 'clubs') {
  img.onclick = () => {
    window.location.href = `clubs/Brinth_G_clubs.php?game=${category}${i+1}`;
  };
  } else if (category === 'diamonds') {
  img.onclick = () => {
    window.location.href = `diamonds/Brinth_G_diamonds.php?game=${category}${i+1}`;
  };
  }
  } else {
      img.classList.add('disabled');
      img.style.opacity = '0.3';
      img.style.cursor = 'not-allowed';
    }

    cardContainer.appendChild(img);
  }

  modal.style.display = 'flex';
}

function closeModal() {
  document.getElementById('cardModal').style.display = 'none';
}
</script>

</body>
</html>
