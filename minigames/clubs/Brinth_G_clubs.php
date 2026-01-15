<?php
/* /brinth_games/Brinth_G_clubs.php
   Generic entry for every Clubs minigame.
   Even ranks (2,4,6,8,10,12) → Hangman   (coming next)
   Odd  ranks (3,5,7,9,11,13) → Crack-the-Code (below)
*/
session_start();
require '../../brinth-database.php';

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: ../../index/brinthgame.php");
    exit();
}
if (!isset($_GET['game'])) die("Game not specified.");

$game_code = $_GET['game'];          
$_SESSION['game_code'] = $game_code; 

if ($game_code === 'clubs14') {
    header("Location: ace_of_clubs.php");
    exit();
}

preg_match('/(\d+)$/', $game_code, $m);
$rank = intval($m[1] ?? 0);

if ($rank % 2 === 0) {
    header("Location: clubs_ctc.php");
} else {
    header("Location: clubs_hangman.php");
}
exit();





