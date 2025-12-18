<?php
/**
 * Function: checkSaviorCard
 * Description: Checks the user's savior_card value from the database (playerinfo table).
 * If savior_card <= -1, redirects to timeout.php.
 */

function checkSaviorCard() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['username'])) {
        return; 
    }

    $username = $_SESSION['username'];

    global $pdo;
    if (!isset($pdo)) {
        trigger_error('Database connection not found.', E_USER_ERROR);
        return;
    }

    try {
        // Get savior_card from the playerinfo table
        $stmt = $pdo->prepare('SELECT savior_card FROM playerinfo WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return; // User not found; nothing to do
        }

        $saviorCard = (int) $user['savior_card'];

        // If savior_card <= -1, redirect to timeout.php
        if ($saviorCard <= -1) {
            header('Location: Brinth_Timeout.php');
            exit();
        }

        // Otherwise, do nothing
    } catch (PDOException $e) {
        error_log('Error checking savior_card: ' . $e->getMessage());
    }
}
checkSaviorCard();
?>
