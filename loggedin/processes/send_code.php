<?php
session_start();
require '../brinth-database.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if user is logged in
if (!isset($_SESSION['username'])) exit;

$username = $_SESSION['username'];

// Get user email
$stmt = $pdo->prepare("SELECT email, username FROM playerinfo WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$email = $user['email'];



// Generate and store code
$code = rand(10000, 99999);
$_SESSION['email_code'] = $code;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'SMTP_USER';
    $mail->Password = 'SMTP_PASS';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('brinthgame@gmail.com', 'Brinth');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Brinth Email Verification';
        $mail->Body = "
            <div style='font-family: Georgia, serif; background-color: #051015cc; color: #815334; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto; text-align: left;'>
                <div style='text-align: center;'>
                    <img src='cid:brinth_logo' alt='Brinth Logo' style='max-width: 120px; margin-bottom: 20px;' />
                    <br>
                    <img src='cid:forgot_img' alt='Brinth Forgot Password Image' style='max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 20px;' />
                </div>
                <p>Hi <strong>{$user['username']}</strong>,</p>
                <p>We really appreciate that you want to verify your email<br>
                This helps us keep the game safe for everyone!</p>

                <div style='text-align: center; margin: 30px 0;'>
                <h3 style='margin: 10px 0;'>Your verification code is:</h3>
                <p style='font-size: 22px; background: #333; color: #92684cff; padding: 12px 24px; border-radius: 8px; display: inline-block; letter-spacing: 1px;'>
                $code
                </p>
                </div>


            <p style='margin-top: 40px;'>Kind Regards,<br><strong>— The Brinth Team</strong></p>
        </div>
        ";
        $mail->AddEmbeddedImage('../../brinth_icons/brinth_logo.png', 'brinth_logo');
        $mail->AddEmbeddedImage('../../brinth_icons/forgot_password_brinth.jpg', 'forgot_img');
    $mail->send();
} catch (Exception $e) {
    // echo "Mailer Error: {$mail->ErrorInfo}";
}
