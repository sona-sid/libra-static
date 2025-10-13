
<?php
require_once __DIR__ . '/functions.php';

$statusMsg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['user_name'] ?? '';
    $email = $_POST['user_email'] ?? '';
    $phone = $_POST['user_phone'] ?? '';
    $service = $_POST['user_service'] ?? '';
    $details = $_POST['user_details'] ?? '';

    // Handle file upload
    $attachmentPath = '';
    $attachmentName = '';
    if (isset($_FILES['user_file']) && $_FILES['user_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $attachmentName = basename($_FILES['user_file']['name']);
        $attachmentPath = $uploadDir . $attachmentName;
        move_uploaded_file($_FILES['user_file']['tmp_name'], $attachmentPath);
    }

    // Save to JSON file
    $formData = [
        "name" => $name,
        "email" => $email,
        "phone" => $phone,
        "service" => $service,
        "details" => $details,
        "file" => $attachmentName,
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

    // Send admin notification
    if ($name && $email && $phone && $service && $details) {
        $email_subject = "New Quote Request: $service";
        $email_body = "Name: $name\nEmail: $email\nPhone: $phone\nService: $service\nDetails:\n$details";
        $sent = sendMailtoAdmin(
            $email_subject,
            $email_body,
            $attachmentPath,
            $attachmentName
        );

        // Send user acknowledgement
        $userMessage = "Thank you for contacting Libra Design! We have received your quote request and will get back to you soon.";
        $userTemplate = getEmailTemplate($name, $userMessage);
        $userSent = sendMail(
            $email,
            "We received your quote request!",
            $userTemplate,
            '',
            '',
            true
        );

        if ($sent && $userSent) {
            $statusMsg = '<div class="success-msg">Thank you for your quote request!</div>';
        } else {
            $statusMsg = '<div class="error-msg">Sorry, we could not send your request. Please try again later.</div>';
        }
    }
}
?>
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
        <form id="quoteForm" method="POST" action="" enctype="multipart/form-data">
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
                <input type="file" id="file" name="user_file" />
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
            <button type="submit" class="quote-submit">Submit Request</button>
          </div>
          <!-- Success message -->
          <div id="successMessage">
            ✅ Thank you! Your request has been submitted. Our team will get back to you soon!
          </div>
        </form>
        <?php
        // Show status message below the form
        if ($statusMsg) {
            echo $statusMsg;
        }
        ?>
      </div>
    </section>
    <footer id="footer">
      <?php include 'footer.php'; ?>
    </footer>
    <script>
      // jquery fn to submit form after validation
      document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("quoteForm");
        const successMessage = document.getElementById("successMessage");

        form.addEventListener("submit", (e) => {
          e.preventDefault(); // prevent default form submission

          // Simple validation (you can expand this as needed)
          let valid = true;
          form.querySelectorAll("input[required], select[required]").forEach((input) => {
            if (!input.value.trim()) {
              valid = false;
              input.nextElementSibling.textContent = "This field is required.";
            } else {
              input.nextElementSibling.textContent = "";
            }
          });

          if (valid) {
            form.submit(); // submit the form if valid
            successMessage.style.display = "block"; // show success message
            form.reset(); // reset the form
          }
        });
      });

    </script>
    <script src="./form.js"></script>
  </body>
</html>