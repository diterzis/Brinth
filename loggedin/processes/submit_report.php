<?php
session_start();
require '../brinth-database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(401);
    exit("Unauthorized");
}

$data = json_decode(file_get_contents("php://input"), true);
$message = trim($data['message']);

if ($message === '') {
    http_response_code(400);
    exit("Empty message");
}

$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT id, email FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

$stmt = $pdo->prepare("INSERT INTO user_reports (user_id, username, email, message) VALUES (?, ?, ?, ?)");
$stmt->execute([$user['id'], $username, $user['email'], $message]);

echo "Report received";
?>
