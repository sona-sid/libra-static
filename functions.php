<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';

// Load credentials from .env
function getMailEnv() {
    static $env = null;
    if ($env === null) {
        $env = parse_ini_file(__DIR__ . '/.env', false, INI_SCANNER_RAW);
    }
    return $env;
}

function sendMail($toEmail, $subject, $body, $attachmentPath = '', $attachmentName = '', $isHtml = false) {
    $env = getMailEnv();
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtpout.secureserver.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = $env['MAIL_USERNAME'];
        $mail->Password   = $env['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->SMTPAutoTLS = true;
        $mail->Timeout    = 30;

        $mail->setFrom($env['MAIL_FROM'], $env['MAIL_NAME']);
        $mail->addAddress($toEmail);

        if ($attachmentPath && file_exists($attachmentPath)) {
            $mail->addAttachment($attachmentPath, $attachmentName);
        }

        $mail->isHTML($isHtml);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Fallback to TLS 587 if SSL fails
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtpout.secureserver.net';
            $mail->SMTPAuth   = true;
            $mail->Username   = $env['MAIL_USERNAME'];
            $mail->Password   = $env['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->SMTPAutoTLS = true;
            $mail->Timeout    = 30;

            $mail->setFrom($env['MAIL_FROM'], $env['MAIL_NAME']);
            $mail->addAddress($toEmail);

            if ($attachmentPath && file_exists($attachmentPath)) {
                $mail->addAttachment($attachmentPath, $attachmentName);
            }

            $mail->isHTML($isHtml);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e2) {
            return false;
        }
    }
}

function sendMailtoAdmin($subject, $body, $attachmentPath = '', $attachmentName = '') {
    $env        = getMailEnv();
    $adminEmail = isset($env['ADMIN_MAIL']) ? $env['ADMIN_MAIL'] : $env['MAIL_FROM'];
    return sendMail($adminEmail, $subject, $body, $attachmentPath, $attachmentName);
}

// Email template with logo
function getEmailTemplate($userName, $message) {
    $logoUrl = 'https://libradesign.in/assets/images/logo_small.png'; // Use absolute URL for emails
    return '
    <div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #eee;padding:24px;">
        <div style="text-align:center;margin-bottom:24px;">
            <img src="' . $logoUrl . '" alt="Libra Design" style="height:60px;">
        </div>
        <h2 style="color:#333;">Hello ' . htmlspecialchars($userName) . ',</h2>
        <p style="color:#555;font-size:16px;">' . $message . '</p>
        <hr style="margin:32px 0;">
        <p style="font-size:13px;color:#999;text-align:center;">&copy; ' . date('Y') . ' Libra Design. All rights reserved.</p>
    </div>
    ';
}