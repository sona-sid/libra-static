<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Load .env file
$env = parse_ini_file(__DIR__ . '/.env', false, INI_SCANNER_RAW);

// Now you can access values like this:
$mailHost = $env['MAIL_HOST'];
$mailPort = $env['MAIL_PORT'];
$mailUser = $env['MAIL_USERNAME'];
$mailPass = $env['MAIL_PASSWORD'];

$mail = new PHPMailer(true);

try {
    // Enable debug output (for testing only)
    $mail->SMTPDebug = 2; 
    $mail->isSMTP();

    $mail->Host       = $env['MAIL_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $env['MAIL_USERNAME'];
    $mail->Password   = $env['MAIL_PASSWORD'];
    $mail->SMTPSecure = 'tls';
    $mail->Port       = $env['MAIL_PORT'];

    $mail->setFrom($env['MAIL_FROM'], $env['MAIL_NAME']);

    //$mail->Host       = 'smtp.secureserver.net'; // 'smtp.office365.com';
    //$mail->SMTPAuth   = true;
    //$mail->Username   = 'info@libradesign.in';   // replace with your email
    //$mail->Password   = '$_email@Libra25';   // replace with your password
    //$mail->SMTPSecure = 'tls';
    //$mail->Port       = 587;

    // Sender & recipient
    //$mail->setFrom('info@libradesign.in', 'Libradesign Test Mailer');
    $mail->addAddress('sonasidharthan1@gmail.com'); // send to yourself

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from EC2';
    $mail->Body    = '✅ If you see this, your EC2 can send emails via GoDaddy/Office 365.';

    $mail->send();
    echo "✅ Test email sent successfully!";
} catch (Exception $e) {
    echo "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

