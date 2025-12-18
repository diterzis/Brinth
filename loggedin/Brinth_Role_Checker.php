<?php

/**
 * Function: checkUserRole
 * Description: Checks the user's XP from the database, determines if their role needs to be updated,
 * updates the "category" field if necessary, reward with 1 addition savior card, and redirects to promoted.php upon promotion.
 */

function checkUserRole()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verify user is logged in
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
        $stmt = $pdo->prepare('SELECT xp, category FROM playerinfo WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return;
        }

        $xp = (int) $user['xp'];
        $currentRole = $user['category'];

        // Determine new role based on XP thresholds
        $role = '';
        if ($xp >= 0     && $xp <= 999) {
            $role = 'Unclassified';
        } elseif ($xp >= 1000  && $xp <= 1999) {
            $role = 'Brinther';
        } elseif ($xp >= 2000  && $xp <= 3499) {
            $role = 'First Class Brinther';
        } elseif ($xp >= 3500  && $xp <= 4999) {
            $role = 'Master Brinther';
        } elseif ($xp >= 5000  && $xp <= 6999) {
            $role = 'Specialist';
        } elseif ($xp >= 7000 && $xp <= 8999) {
            $role = 'Captain';
        } elseif ($xp >= 9000 && $xp <= 9999) {
            $role = 'Major Brinther';
        } elseif ($xp >= 10000 && $xp <= 11999) {
            $role = 'Command Brinth Major';
        } elseif ($xp >= 12000) {
            $role = 'Leader';
        }

        // If the role has changed, update the database (and grant +1 savior card) and redirect
        if ($role !== $currentRole) {
            $updateStmt = $pdo->prepare('
        UPDATE playerinfo
        SET category = :category,
            savior_card = savior_card + 1
        WHERE username = :username
    ');
            $updateStmt->execute([
                ':category' => $role,
                ':username' => $username
            ]);

            // Keep session in sync if it stores these
            $_SESSION['category'] = $role;
            if (isset($_SESSION['savior_card'])) {
                $_SESSION['savior_card'] = (int)$_SESSION['savior_card'] + 1;
            }

            // NEW: pass old/new roles to the promo page
            $_SESSION['promo_old_role'] = $currentRole;   // was in DB before update
            $_SESSION['promo_new_role'] = $role;          // updated role by XP

            // Redirect to promotion page
            header('Location: Brinth_Promo.php');
            exit();
        }

        // No change in role; continue normally
    } catch (PDOException $e) {
        error_log('Error checking user role: ' . $e->getMessage());
    }
}
checkUserRole();
