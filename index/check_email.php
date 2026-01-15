<?php
// check_email.php

// Ensure you output only JSON and nothing else
header('Content-Type: application/json');

require 'brinth-database.php';

if (isset($_GET['email'])) {
    $email = trim($_GET['email']);

    // Validate the email format using PHP filter
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['available' => false, 'message' => 'Invalid email format']);
        exit();
    }

    // Prepare the query to count emails in the database
    $sql = "SELECT COUNT(*) FROM playerinfo WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo json_encode(['available' => false, 'message' => 'Email already registered']);
    } else {
        echo json_encode(['available' => true, 'message' => 'Email available']);
    }
    exit();
}
?>
