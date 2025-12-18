<?php
require '../brinth-database.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request."]);
    exit;
}

$username = trim($data['username'] ?? '');
$email    = trim($data['email'] ?? '');
$category = trim($data['category'] ?? '');
$message  = trim($data['message'] ?? '');

if ($username === '' || $email === '' || $category === '' || $message === '') {
    http_response_code(400);
    echo json_encode(["error" => "Please fill in all fields."]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO guest_reports (username, email, category, message)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$username, $email, $category, $message]);
    echo json_encode(["status" => "success"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Something went wrong. Please try again later."]);
}
