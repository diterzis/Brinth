<?php
require 'brinth-database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['date_of_birth'];
    $password = $_POST['password'];
    
    // puthing a hash for password - encrypting for safety
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Prepare and insert user into the database
    $sql = "INSERT INTO playerinfo (username, email, date_of_birth, password_hash) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([$username, $email, $dob, $password_hash]);
        echo "Registration successful!";  // Temporary success message

        // Redirect to login for new members page
        header("Location: brinth_newmember.php");
        exit();

    } catch (PDOException $e) {
        echo "Error during registration: " . $e->getMessage();
    }
}
?>


