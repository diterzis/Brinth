<?php
session_start();
require 'brinth-database.php';
require 'Brinth_Role_Checker.php';
require 'Brinth_Savior_Checker.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index/brinthgame.php");
    exit();
}

$username = $_SESSION['username'];

$stmt = $pdo->prepare("SELECT email, created_at, email_ver FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$email = $row['email'];
$memberSince = date("F j, Y", strtotime($row['created_at']));
$emailVer = $row['email_ver'] ?? 'Not Verified';

if (isset($_SESSION['message'])): ?>
    <div class="info-message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
  <?php endif;
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Settings - Brinth</title>
  <link rel="stylesheet" href="../brinth_styles/inside/settings.css">
  <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
</head>
<body>
  <div class="page-container">
    <div class="page-title">SETTINGS</div>

    <div class="info-section">
      <p>Member Since: <span><?= $memberSince ?></span></p>
    </div>

    <hr>

<div class="info-section">
  <p>Email: <span><?= htmlspecialchars($email) ?></span></p>

  <?php if ($emailVer !== 'Verified'): ?>
    <button class="small-button" onclick="openCodeModal()">Verify</button>
  <?php else: ?>
    <p class="verified-text"> ↳ Verified 🗸</p>
  <?php endif; ?>
</div>

    <div id="codeModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeCodeModal()">&times;</span>
        <p>A message has been sent to your email.<br>Check it and enter the 5-digit code:</p>
        <form method="POST" action="processes/verify_email.php">
          <input type="text" name="code" maxlength="5" required placeholder="Enter code">
          <button type="submit" name="verify_code">Verify</button>
        </form>
      </div>
    </div>

    <hr>

    <div class="info-section">
      <h3>Change Email</h3>
      <form method="POST" action="processes/change_email.php">
        <input type="email" name="new_email" placeholder="New email" required>
        <button type="submit" name="change_email">Change Email</button>
      </form>
    </div>

    <hr>

    <div class="info-section">
      <h3>Change Password</h3>
      <form method="POST" action="processes/change_password.php">
        <input type="password" name="current_pass" placeholder="Current password" required>
        <input type="password" name="new_pass" placeholder="New password" required>
        <input type="password" name="verify_pass" placeholder="Verify new password" required>
        <button type="submit" name="change_pass">Change Password</button>
      </form>
    </div>

    <div class="back-button-container">
      <a href="protected_page.php" class="back-button">Back to Main</a>
    </div>
  </div>

  <script>
    function openCodeModal() {
      fetch("processes/send_code.php"); // trigger email code
      document.getElementById("codeModal").style.display = "flex";
    }

    function closeCodeModal() {
      document.getElementById("codeModal").style.display = "none";
    }
  </script>
</body>
</html>
