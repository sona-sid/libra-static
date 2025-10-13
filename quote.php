<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LIBRA DESIGN</title>
    <link href="./home.css" rel="stylesheet" />
    <link href="./style.css" rel="stylesheet" />
  </head>
  <body class="quote">
    <!-- banner -->
    <section class="hero-section">
      <div class="hero-box">
        <img src="./assets/images/banner.png" alt="Hero" class="hero-about" />

        <div class="hero-nav">
          <ul class="bebas hero-nav-list">
            <li><a href="./">Home</a></li>
            <li><a href="./aboutus.html">About Us</a></li>
            <li><a href="./portfolio.html">Portfolio</a></li>
            <li><a href="./contactus.html">Contact</a></li>
          </ul>
        </div>

        <div class="hero-logo">
          <img src="./assets/images/logo_small.png" alt="Creative Print" />
        </div>

        <div class="abt-text">
          <h1 class="bebas abt-heading">
            Request a <br />
            <span class="highlight">Quote </span>
          </h1>
        </div>

        <div class="hero-image-wrapper">
          <img
            src="./assets/images/brain-small.png"
            alt="Creative Print"
            class="hero-image"
          />
        </div>
      </div>
    </section>
    <section class="container">
      <div class="form-header">
        <h2>REQUEST A QUOTE</h2>
        <p>
          Tell us your printing needs and we’ll get back with a custom
          quotation.
        </p>
      </div>
      <div class="quote-form-container">
        <form id="quoteForm" method="POST" action="quote.php">
          <div class="form-grid">
            <!-- Personal Information -->
            <div class="form-section">
              <h3>Personal Information</h3>
              <div class="input-group">
                <input
                  type="text"
                  id="fullname"
                  name="user_name"
                  placeholder="John Doe"
                  required
                />
                <label for="fullname">Full Name *</label>
                <span class="error"></span>
              </div>
              <div class="input-group">
                <input
                  type="email"
                  id="email"
                  name="user_email"
                  placeholder="your_email@example.com"
                  required
                />
                <label for="email">E-mail Address *</label>
                <span class="error"></span>
              </div>
              <div class="input-group">
                <input
                  type="tel"
                  id="phone"
                  name="user_phone"
                  placeholder="( _ ) ___ - ____"
                  required
                />
                <label for="phone">Phone Number *</label>
                <span class="error"></span>
              </div>
              <div class="input-group">
                <input type="text" id="company" placeholder="If Available" />
                <label for="company">Company Name</label>
                <span class="error"></span>
              </div>
            </div>

            <!-- Project Information -->
            <div class="form-section">
              <h3>Project Information</h3>
              <div class="input-group">
                <select id="service" name="user_service">
                  <option value="">Select Service</option>
                  <option value="flyers">Flyers</option>
                  <option value="brochures">Brochures</option>
                  <option value="businesscards">Business Cards</option>
                </select>
                <label for="service">Printing Service Type</label>
                <span class="error"></span>
              </div>
              <div class="input-group">
                <label for="quantity">Quantity Needed</label>
                <input type="number" id="quantity" name="quantity" placeholder="0" required />
                <span class="error"></span>
              </div>
              <div class="input-group">
                <select id="material" name="material">
                  <option value="glossy">Glossy</option>
                  <option value="matte">Matte</option>
                  <option value="textured">Textured</option>
                </select>
                <label for="material">Paper/Material Type</label>
                <span class="error"></span>
              </div>
              <div class="input-group">
                <input
                  type="text"
                  id="size"
                  name="size"
                  required
                  placeholder="e.g. A4, A5, Custom"
                />
                <label for="size">Size</label>
                <span class="error"></span>
              </div>
            </div>
          </div>
          <!-- Additional Information -->
          <hr class="horiz-line" />
          <div class="form-grid">
            <div class="form-section full-width">
              <h3>Additional Information</h3>
              <div class="input-group file">
                <input type="file" id="file" name="file" />
                <label for="file">Upload File</label>
                <span class="error"></span>
              </div>
              <div class="input-group">
                <textarea id="notes" name="user_details"></textarea>
                <label for="notes">Additional Notes</label>
                <span class="error"></span>
              </div>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit">Submit Request</button>
          </div>
          <!-- Success message -->
          <div id="successMessage">
            ✅ Thank you! Your request has been submitted. Our team will get back to you soon!
          </div>
        </form>
      </div>
    </section>
    <footer id="footer">
      <?php include 'footer.php'; ?>
    </footer>
    <script>
      // Load footer.html content
      // fetch("footer.html")
      //   .then((response) => response.text())
      //   .then((data) => {
      //     document.getElementById("footer").innerHTML = data;
      //   });
    </script>
    <script src="./form.js"></script>
  </body>
</html>

<?php
// filepath: c:\xampp\htdocs\php\quote.php
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

function sendMail($host, $port, $encryption, $username, $password, $fromEmail, $fromName, $toEmail, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
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

        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data (update field names as per your quote form)
    $name = $_POST['user_name'] ?? '';
    $email = $_POST['user_email'] ?? '';
    $phone = $_POST['user_phone'] ?? '';
    $service = $_POST['user_service'] ?? '';
    $details = $_POST['user_details'] ?? '';

    // Save to JSON file
    $formData = [
        "name" => $name,
        "email" => $email,
        "phone" => $phone,
        "service" => $service,
        "details" => $details,
        "timestamp" => date("Y-m-d H:i:s")
    ];
    $jsonFile = 'quote_submissions.json';
    if (file_exists($jsonFile)) {
        $existing = json_decode(file_get_contents($jsonFile), true);
        if (!is_array($existing)) $existing = [];
    } else {
        $existing = [];
    }
    $existing[] = $formData;
    file_put_contents($jsonFile, json_encode($existing, JSON_PRETTY_PRINT));

    // if all inputs are present, send email
    if ($name && $email && $phone && $service && $details) {
        $email_subject = "New Quote Request: $service";
        $email_body = "Name: $name\nEmail: $email\nPhone: $phone\nService: $service\nDetails:\n$details";

        // Try SSL 465 first, fallback to TLS 587
        $sent = sendMail(
            'smtpout.secureserver.net',
            465,
            PHPMailer::ENCRYPTION_SMTPS,
            $username,
            $password,
            $fromEmail,
            $fromName,
            $toEmail,
            $email_subject,
            $email_body
        );
        if (!$sent) {
            $sent = sendMail(
                'smtpout.secureserver.net',
                587,
                PHPMailer::ENCRYPTION_STARTTLS,
                $username,
                $password,
                $fromEmail,
                $fromName,
                $toEmail,
                $email_subject,
                $email_body
            );
        }
        if ($sent) {
            echo "<script>alert('Thank you for your quote request!');</script>";
        } else {
            echo "<script>alert('Sorry, we could not send your request. Please try again later.');</script>";
        }
    }
}
?>
