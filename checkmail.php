<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Load credentials from .env
$env = parse_ini_file(__DIR__ . '/.env', false, INI_SCANNER_RAW);

$username = $env['MAIL_USERNAME'];
$password = $env['MAIL_PASSWORD'];
$fromEmail = $env['MAIL_FROM'];
$fromName = $env['MAIL_NAME'];
$toEmail = 'sonasidharthan1@gmail.com'; // recipient

// PHPMailer setup function
function sendMail($host, $port, $encryption, $username, $password, $fromEmail, $fromName, $toEmail, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 2; // debug level
        $mail->isSMTP();
        $mail->Host       = $host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $username;
        $mail->Password   = $password;
        $mail->SMTPSecure = $encryption;
        $mail->Port       = $port;
        $mail->SMTPAutoTLS = true;
        $mail->Timeout    = 30;

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo "✅ Test email sent successfully using $encryption:$port!\n";
        return true;
    } catch (Exception $e) {
        echo "❌ Failed with $encryption:$port. Error: {$mail->ErrorInfo}\n";
        return false;
    }
}

// First attempt: SSL on 465
$sent = sendMail(
    'smtpout.secureserver.net',
    465,
    PHPMailer::ENCRYPTION_SMTPS,
    $username,
    $password,
    $fromEmail,
    $fromName,
    $toEmail,
    'Test Email from EC2',
    '✅ Test email via GoDaddy Professional Email (SSL 465).'
);

// Fallback: TLS on 587 if first attempt fails
if (!$sent) {
    sendMail(
        'smtpout.secureserver.net',
        587,
        PHPMailer::ENCRYPTION_STARTTLS,
        $username,
        $password,
        $fromEmail,
        $fromName,
        $toEmail,
        'Test Email from EC2',
        '✅ Test email via GoDaddy Professional Email (TLS 587).'
    );
}
