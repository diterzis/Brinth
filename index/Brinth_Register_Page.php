<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  header("Location: ../loggedin/protected_page.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Brinth</title>
  <link rel="stylesheet" href="../brinth_styles/index/Brinth_Register.css" />
  <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap" rel="stylesheet" />
  <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png" />
  <link rel="stylesheet" href="../brinth_styles/index/brinth_footer.css">
</head>

<body>
  <h1 class="create-heading">Create an<br>Account</h1>

  <!-- Main Area -->
  <div class="container">

    <div class="container">
      <div class="register-form">
        <h2>Sign Up</h2>
        <form id="registerForm" action="brinthregister.php" method="POST">
          <input type="text" id="reg-username" name="username" placeholder="Pick a Username" required>
          <small id="reg-username-status" class="status-msg"></small>
          <input type="email" id="reg-email" name="email" placeholder="Enter your Email" required>
          <small id="reg-email-status" class="status-msg"></small>
          <input type="password" id="reg-password" name="password" placeholder="Pick a Password" required>
          <small id="reg-password-status" class="status-msg"></small>
          <input type="date" id="reg-dob" name="date_of_birth" max="<?= date('Y-m-d') ?>" required>
          <button type="submit" id="register-btn" disabled>Register</button>
        </form>
        <p style="text-align: center; margin-top: -10px;">
          Already a member? <a href="brinth_newmember.php" style="color: #d6a78a; font-weight: bold; text-decoration: underline;">Log in</a>
        </p>
      </div>
    </div>
  </div>
  <a href="brinthgame.php" class="brinth-logo-floating">
    <img src="../brinth_icons/brinth_logo.png" alt="Brinth Logo">
  </a>

  <?php include 'brinth_footer.php'; ?>
  <script src="Brinth_Sin_Script.js" defer></script>

</body>

</html>