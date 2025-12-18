<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require 'brinth-database.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['recovery_email'] ?? '';
    $email = trim($email);
    if (empty($email)) {
        echo json_encode(['status' => 'not_found']);
        exit;
    }
    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM playerinfo WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        echo json_encode(['status' => 'not_found']);
        exit;
    }

    if ($user['email_ver'] !== 'Verified') {
        echo json_encode(['status' => 'not_verified']);
        exit;
    }

    // Generate strong password
    function generatePassword($length = 10) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        return substr(str_shuffle(str_repeat($chars, $length)), 0, $length);
    }

    $newPassword = generatePassword();
    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update in DB
    $update = $pdo->prepare("UPDATE playerinfo SET password_hash = ? WHERE email = ?");
    $update->execute([$hashed, $email]);

    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'SMTP_USER';
        $mail->Password = 'SMTP_PASS';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('brinthgame@gmail.com', 'Brinth Support');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Brinth Password Reset';
        $mail->Body = "
            <div style='font-family: Georgia, serif; background-color: #0a0a0a; color: #f5f5f5; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto; text-align: left;'>
                <div style='text-align: center;'>
                    <img src='cid:brinth_logo' alt='Brinth Logo' style='max-width: 120px; margin-bottom: 20px;' />
                    <br>
                    <img src='cid:forgot_img' alt='Brinth Forgot Password Image' style='max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 20px;' />
                </div>
                <p>Hi <strong>{$user['username']}</strong>,</p>
                <p>After your request, we have now set your new password.<br>
                It's ready and the only thing you have to do is log in!</p>

                <div style='text-align: center; margin: 30px 0;'>
                <h3 style='margin: 10px 0;'>Your new password is:</h3>
                <p style='font-size: 22px; background: #333; color: #ffcc66; padding: 12px 24px; border-radius: 8px; display: inline-block; letter-spacing: 1px;'>
                $newPassword
                </p>
                </div>

                <div style='text-align: center; margin: 20px 0;'>
                    <h3>Wanna Play?</h3>
                    <a href='http://localhost/brinth/index/brinth_newmember.php' 
                    style='display: inline-block; background-color: #0a2342; color: white;
                    padding: 12px 24px; border-radius: 6px; font-weight: bold; text-decoration: none;'>
                    Log in Here
                </a>
            </div>

            <p style='margin-top: 40px;'>Kind Regards,<br><strong>— The Brinth Team</strong></p>
        </div>
        ";
        $mail->AddEmbeddedImage('../brinth_icons/brinth_logo.png', 'brinth_logo');
        $mail->AddEmbeddedImage('../brinth_icons/forgot_password_brinth.jpg', 'forgot_img');
        $mail->send();
        echo json_encode(['status' => 'sent']);
    } catch (Exception $e) {
        error_log("Mailer error: " . $mail->ErrorInfo);
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'error']);
}
