<?php
// File: sendEmail.php
// Path: C:\xampp\htdocs\Contact_Form_Email\sendEmail.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload via Composer
require __DIR__ . '/../vendor/autoload.php';

//Added function to send email
function sendMail(
    string $to,
    string $toName,
    string $subject,
    string $htmlBody,
    string $altBody,
    string $from = 'no-reply@atlasgroup.com',
    string $fromName = 'Atlas Group'
): bool {
    $mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';   // SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'trpk152@gmail.com'; // Full email address
    $mail->Password   = 'gfcn fmxh dvet dmlp'; 
    $mail->SMTPSecure = 'tls';              // Encryption: 'tls'
    $mail->Port       = 587;                // TLS port

    // Sender/recipient
    $mail->setFrom($from, $fromName);
    $mail->addAddress($to, $toName);

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $htmlBody;
    $mail->AltBody = $altBody;

    // Send it
    $mail->send();
    return true;
} catch (Exception $e) {
    error_log("Mailer Error ({$to}): " . $mail->ErrorInfo);
    return false;
}
}
?>

