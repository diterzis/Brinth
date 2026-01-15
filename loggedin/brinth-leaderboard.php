<?php
session_start();
require 'brinth-database.php';
require 'Brinth_Role_Checker.php';
require 'Brinth_Savior_Checker.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: ../index/brinthgame.php");
  exit();
}

$username = $_SESSION['username'] ?? '';

$stmt = $pdo->query("SELECT username, category, xp, games_won FROM playerinfo ORDER BY xp DESC LIMIT 10");
$topPlayers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rankStmt = $pdo->prepare("
  SELECT COUNT(*) + 1 AS user_rank
  FROM playerinfo
  WHERE xp > (SELECT xp FROM playerinfo WHERE username = ?)
");
$rankStmt->execute([$username]);
$userRank = (int)($rankStmt->fetch(PDO::FETCH_ASSOC)['user_rank'] ?? 0);

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

function icon_for($cat, $map) {
  return isset($map[$cat]) ? $map[$cat].'.png' : 'default_icon.png';
}

function ordn($n) {
  if (in_array($n%100, [11,12,13])) return $n.'th';
  return $n.(['th','st','nd','rd','th','th','th','th','th','th'][$n%10]);
}

function rank_message($rank) {
  if (!$rank || $rank < 1) return '';
  if ($rank === 1) return "You're in the 1st place, Congratulations!";
  if ($rank === 2) return "You're 1st Runner-Up, you're close..!";
  if ($rank === 3) return "You're 2nd Runner-Up, fight a little more!";
  if ($rank <= 5) return "You're ".ordn($rank).", fight more to be in the top 3";
  if ($rank <= 10) return "You're currently in ".ordn($rank)." place, play wise from now on";
  return "You're currently in ".ordn($rank)." place!";
}

$top5  = array_slice($topPlayers, 0, 5);
$rest5 = array_slice($topPlayers, 5, 5);

$slots = [
  4 => ($top5[3] ?? null), // 4th place
  2 => ($top5[1] ?? null), // 2nd place
  1 => ($top5[0] ?? null), // 1st place
  3 => ($top5[2] ?? null), // 3rd place
  5 => ($top5[4] ?? null), // 5th place
];

$inTop10 = false;
foreach ($topPlayers as $p) {
  if (($p['username'] ?? '') === $username) {
    $inTop10 = true;
    break;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Leaderboard - Brinth</title>
  <link rel="stylesheet" href="../brinth_styles/lead.css" />
  <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png" />
</head>
<body>
  <div class="wrap">
    <div class="hdr">
      <span class="bar"></span>
      <h1>LEADERBOARD</h1>
      <span class="bar"></span>
    </div>

    <section class="panel">
      <!-- Top 5 -->
      <div class="top5" id="top5">
        <?php foreach ([4,2,1,3,5] as $rank):
          $p = $slots[$rank] ?? null;
          if (!$p) continue;
          $isMe = ($p['username'] === $username);
          $cat  = htmlspecialchars($p['category'] ?? '');
          $xp   = (int)$p['xp'];
          $won  = (int)($p['games_won'] ?? 0);
          $icon = icon_for($cat, $iconMap);
        ?>
          <div class="badge-group" data-rank="<?= $rank ?>">
            <div
              class="badge slot-<?= $rank ?><?= $isMe ? ' me' : '' ?>"
              data-name="<?= htmlspecialchars($p['username']) ?>"
              data-role="<?= $cat ?>"
              data-xp="<?= $xp ?>"
              data-won="<?= $won ?>"
            >
              <div class="b-name"><?= htmlspecialchars($p['username']) ?></div>
              <div class="b-icon"><img src="../brinth_icons/<?= $icon ?>" alt=""></div>
            </div>

            <!-- Drop window -->
            <div class="badge-drop" aria-hidden="true">
              <div class="bd-inner">
                <div class="bd-place"></div>
                <div class="bd-divider"></div>
                <div class="bd-name"></div>
                <div class="bd-role"></div>
                <div class="bd-divider"></div>
                <div class="bd-stats-title">Stats</div>
                <div class="bd-stats">
                  <div class="bd-stat"><span>XP</span><strong class="bd-xp"></strong></div>
                  <div class="bd-stat"><span>GAMES WON</span><strong class="bd-won"></strong></div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- 6th to 10 list -->
      <div class="list">
        <?php foreach ($rest5 as $i => $p):
          $rank = 6 + $i;
          $isMe = ($p['username'] === $username);
          $cat  = htmlspecialchars($p['category'] ?? '');
          $xp   = number_format((int)$p['xp']);
          $icon = icon_for($cat, $iconMap);
        ?>
          <div class="row<?= $isMe ? ' me' : '' ?>">
            <div class="col rk"><?= strtoupper(ordn($rank)) ?></div>
            <div class="col nm"><?= htmlspecialchars($p['username']) ?></div>
            <div class="col rl"><?= strtoupper($cat) ?></div>
            <div class="col ic"><img src="../brinth_icons/<?= $icon ?>" alt=""></div>
            <div class="col xp"><?= $xp ?> XP</div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

<div class="rank-msg">
  <?= $inTop10
      ? htmlspecialchars(rank_message($userRank))
      : "You're currently in ".htmlspecialchars(ordn($userRank))." place!"; ?>
</div>

    <div class="back">
      <a href="protected_page.php" class="start-button">Back to Main</a>
    </div>
  </div>

  <script>
    (function(){
      const groups = document.querySelectorAll('.badge-group');
      let openGroup = null;

      function ordn(n){
        const s=["th","st","nd","rd"];
        const v=n%100;
        return n+(s[(v-20)%10]||s[v]||s[0]);
      }
      function fmt(n){ return (+n).toLocaleString(); }

      groups.forEach(g=>{
        const badge = g.querySelector('.badge');
        const drop  = g.querySelector('.badge-drop');
        const place = g.querySelector('.bd-place');
        const name  = g.querySelector('.bd-name');
        const role  = g.querySelector('.bd-role');
        const xp    = g.querySelector('.bd-xp');
        const won   = g.querySelector('.bd-won');

        function positionDrop(){
          const b = badge.getBoundingClientRect();
          const host = g.getBoundingClientRect();
          const left = b.left - host.left;
          const top  = b.bottom - host.top + 10;
          drop.style.left = left + 'px';
          drop.style.top  = top  + 'px';
          drop.style.width = b.width + 'px';
        }

        function open(){
          place.textContent = ordn(parseInt(g.dataset.rank,10)) + ' Place';
          name.textContent  = badge.dataset.name || '';
          role.textContent  = badge.dataset.role || '';
          xp.textContent    = fmt(badge.dataset.xp || 0);
          won.textContent   = fmt(badge.dataset.won || 0);

          positionDrop();
          drop.classList.add('show');
          drop.setAttribute('aria-hidden','false');
          openGroup = g;
        }

        function close(){
          drop.classList.remove('show');
          drop.setAttribute('aria-hidden','true');
          if (openGroup === g) openGroup = null;
        }

        badge.addEventListener('click', ()=>{
          if (drop.classList.contains('show')) { close(); return; }
          if (openGroup && openGroup !== g) {
            openGroup.querySelector('.badge-drop').classList.remove('show');
            openGroup.querySelector('.badge-drop').setAttribute('aria-hidden','true');
          }
          open();
        });

        window.addEventListener('resize', ()=>{
          if (drop.classList.contains('show')) positionDrop();
        });
      });

      document.addEventListener('click', (e)=>{
        if (!openGroup) return;
        if (e.target.closest('.badge-group')) return;
        openGroup.querySelector('.badge-drop').classList.remove('show');
        openGroup.querySelector('.badge-drop').setAttribute('aria-hidden','true');
        openGroup = null;
      });
    })();
  </script>
</body>
</html>
