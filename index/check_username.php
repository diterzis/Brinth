<?php
require 'brinth-database.php';

// Check that username is provided
if (isset($_GET['username'])) {
    $username = trim($_GET['username']);
    
    // Basic validation
    if (strlen($username) < 3) {
        echo json_encode(['available']);
        exit();
    }
    
    // Prepare and execute a query to check if the username already exists
    $sql = "SELECT COUNT(*) FROM playerinfo WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo json_encode(['available' => false, 'message' => 'Trying to be someone else? Username is taken.']);
    } else {
        echo json_encode(['available' => true, 'message' => 'Good one & Available']);
    }
}
?>
