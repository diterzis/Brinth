<?php
$host = 'DB_HOST';
$dbname = 'DB_NAME';
$user = 'DB_USER';
$password = 'DB_PASS';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "";  // Temporary test message
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>