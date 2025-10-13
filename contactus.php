<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LIBRA DESIGN</title>
    <link href="./home.css" rel="stylesheet" />
    <link href="./style.css" rel="stylesheet" />
  </head>
  <body>
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
            <span class="highlight">Get in Touch </span>
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

    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';
    require_once __DIR__ . '/functions.php';

    $adminEmail = 'sonasidharthan1@gmail.com';
    $statusMsg = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $firstName = $_POST['user_firstname'] ?? '';
        $lastName = $_POST['user_lastname'] ?? '';
        $email = $_POST['user_email'] ?? '';
        $phone = $_POST['user_phone'] ?? '';
        $subject = $_POST['user_subject'] ?? '';
        $message = $_POST['user_message'] ?? '';

        // Save to JSON file
        $formData = [
            "firstName" => $firstName,
            "lastName" => $lastName,
            "email" => $email,
            "phone" => $phone,
            "subject" => $subject,
            "message" => $message,
            "timestamp" => date("Y-m-d H:i:s")
        ];
        $jsonFile = 'contact_submissions.json';
        if (file_exists($jsonFile)) {
            $existing = json_decode(file_get_contents($jsonFile), true);
            if (!is_array($existing)) $existing = [];
        } else {
            $existing = [];
        }
        $existing[] = $formData;
        file_put_contents($jsonFile, json_encode($existing, JSON_PRETTY_PRINT));

        // Send admin notification
        if ($firstName && $lastName && $email && $phone && $subject && $message) {
            $email_subject = "New Contact Form Submission: $subject";
            $email_body = "Name: $firstName $lastName\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage:\n$message";
            $sent = sendMailtoAdmin(
                $email_subject,
                $email_body,
                '',
                '',
                false
            );
            if ($sent) {
                $statusMsg = '<div class="success-msg">Thank you for contacting us!</div>';
            } else {
                $statusMsg = '<div class="error-msg">Sorry, we could not send your message. Please try again later.</div>';
            }

            // Send user acknowledgement
            $userMessage = "Thank you for contacting Libra Design! We have received your message and will get back to you soon.";
            $userTemplate = getEmailTemplate($firstName . ' ' . $lastName, $userMessage);
            $userSent = sendMail(
                $email,
                "Thank you for contacting us! We received your message.",
                $userTemplate,
                '',
                '',
                true
            );

            if ($sent && $userSent) {
                $statusMsg = '<div class="success-msg">Thank you for contacting us!</div>';
            } else {
                $statusMsg = '<div class="error-msg">Sorry, we could not send your message. Please try again later.</div>';
            }
        }
    }
    ?>

    <!-- Contact Section -->
    <section class="contact-section container">
      <h2 class="contact-title">Contact Us</h2>
      <p class="contact-subtitle">
        Any question or remarks? Just write us a message!
      </p>

      <div class="contact-container">
        <!-- LEFT SIDE -->
        <div class="contact-info">
          <h3>Contact Information</h3>
          <p>Have questions or need assistance? We're here to help</p>

          <ul class="info-list">
            <li>
              <span>
                <img src="./assets/icons/phone.png" />
              </span>
              0484 4061415
            </li>
            <li>
              <span>
                <img
                  src="./assets/icons/mail.png"
                  style="width: 23px; height: 19px"
              /></span>
              libradesign@gmail.com
            </li>
            <li>
              <span>
                <img
                  src="./assets/icons/location.png"
                  style="width: 19px; height: 25px"
              /></span>
              372 A,<br />
              Libra Tower, St.Francis Xavier Church Road,<br />
              Kaloor, Kochi - 682 018
            </li>
            <li style="margin-bottom: 110px">
              <span>
                <img
                  src="./assets/icons/clock.png"
                  style="width: 24px; height: 24px"
              /></span>
              Working Hours: Mon–Sat,<br />
              9:00 AM – 7:00 PM
            </li>
          </ul>

          <div class="social-icons">
            <a href="#">
              <img src="./assets/icons/twitter.png" />
            </a>
            <a href="#"><img src="./assets/icons/insta.png" /></a>
            <a href="#"><img src="./assets/icons/fb-white.png" /></a>
          </div>

          <div class="bg-circles">
            <div class="circle purple"></div>
            <div class="circle red"></div>
          </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="contact-form">
          <form id="contactForm" method="POST" action="">
            <div class="form-row">
              <div class="form-group">
                <label>First Name</label>
                <input type="text" placeholder="John" name="user_firstname" />
                <span class="error"></span>
              </div>
              <div class="form-group">
                <label>Last Name</label>
                <input type="text" placeholder="Doe" name="user_lastname" />
                 <span class="error"></span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="user_email" placeholder="your_email@example.com"
                />
                 <span class="error"></span>
              </div>
              <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name='user_phone' placeholder="+1012 3456 789"  />
                 <span class="error"></span>
              </div>
            </div>

            <div class="form-group subject">
              <label>Select Subject?</label>
              <div class="radio-group">
                <label>
                  <input type="radio" name="user_subject" value="General Inquiry"  checked />
                  <span>General Inquiry</span>
                </label>

                <label>
                  <input type="radio" name="user_subject" value="Print Inquiry" />
                  <span>Print Inquiry</span>
                </label>

                <label>
                  <input type="radio" name="user_subject" value="Design Inquiry" />
                  <span>Design Inquiry</span>
                </label>

                <label>
                  <input type="radio" name="user_subject" value="Branding Inquiry" />
                  <span>Branding Inquiry</span>
                </label>
              </div>
            </div>

            <div class="form-group message">
              <label>Message</label>
              <textarea id="message" name="user_message"  placeholder="Write your message.." ></textarea>
            </div>
            <div class="msg-btn">
              <button type="submit" class="btn-send">Send Message</button>
            </div>
            <div class="letter_send">
              <img src="./assets/images/letter_send.png" />
            </div>
          </form>

          <?php
          // Show status message below the form
          if ($statusMsg) {
              echo $statusMsg;
          }
          ?>
        </div>
      </div>
    </section>
    <!-- Contact Section ends -->

    <!-- Find Us Section -->
    <section class="find-us-section container">
      <div class="find-us-container">
        <div class="find_us">
          <img src="./assets/images/find_us.png" />
        </div>
        <!-- Right Map -->
        <div class="map-card">
          <img src="./assets/images/location.png" />
        </div>
      </div>
    </section>
    <footer id="footer">
      <?php include 'footer.php'; ?>
    </footer>
    <script>
      // add validations to the contact form
      const contactForm = document.getElementById("contactForm");
      const firstName = contactForm.querySelector("input[name='user_firstname']");
      const lastName = contactForm.querySelector("input[name='user_lastname']");
      const email = contactForm.querySelector("input[name='user_email']");
      const phone = contactForm.querySelector("input[name='user_phone']");
      const message = contactForm.querySelector("textarea[name='user_message']");
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const phonePattern = /^\+?[0-9\s\-()]{7,15}$/
      contactForm.addEventListener("submit", function (e) {
        let valid = true;

        // Validate First Name
        if (firstName.value.trim() == "") {
          setError(firstName, "First name is required");
          valid = false;
        } else {
          clearError(firstName);
        }

        // Validate Last Name
        if (lastName.value.trim() === "") {
          setError(lastName, "Last name is required");
          valid = false;
        } else {
          clearError(lastName);
        }

        // Validate Email
        if (email.value.trim() === "") {
          setError(email, "Email is required");
          valid = false;
        } else if (!emailPattern.test(email.value.trim())) {
          setError(email, "Invalid email format");
          valid = false;
        } else {
          clearError(email);
        }

        // Validate Phone
        if (phone.value.trim() === "") {
          setError(phone, "Phone number is required");
          valid = false;
        } else if (!phonePattern.test(phone.value.trim())) {
          setError(phone, "Invalid phone number format");
          valid = false;
        } else {
          clearError(phone);
        }

        // Validate Message
        if (message.value.trim() === "") {
          setError(message, "Message is required");
          valid = false;
        } else {
          clearError(message);
        }

        if (!valid) {
          e.preventDefault(); // Prevent form submission if validation fails
        }
      });
      function setError(element, message) {
        const formGroup = element.parentElement;
        const errorSpan = formGroup.querySelector(".error");
        errorSpan.textContent = message;
        element.classList.add("input-error");
      }
      function clearError(element) {
        const formGroup = element.parentElement;
        const errorSpan = formGroup.querySelector(".error");
        errorSpan.textContent = "";
        element.classList.remove("input-error");
      }

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(function() {
  $("#contactForm").on("submit", function(e) {
    let valid = true;

    // Clear all errors first
    $(".error").text("");
    $(".input-error").removeClass("input-error");

    // Validate First Name
    const firstName = $("input[name='user_firstname']");
    if ($.trim(firstName.val()) === "") {
      firstName.addClass("input-error").siblings(".error").text("First name is required");
      valid = false;
    }

    // Validate Last Name
    const lastName = $("input[name='user_lastname']");
    if ($.trim(lastName.val()) === "") {
      lastName.addClass("input-error").siblings(".error").text("Last name is required");
      valid = false;
    }

    // Validate Email
    const email = $("input[name='user_email']");
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if ($.trim(email.val()) === "") {
      email.addClass("input-error").siblings(".error").text("Email is required");
      valid = false;
    } else if (!emailPattern.test(email.val().trim())) {
      email.addClass("input-error").siblings(".error").text("Invalid email format");
      valid = false;
    }

    // Validate Phone
    const phone = $("input[name='user_phone']");
    const phonePattern = /^\+?[0-9\s\-()]{7,15}$/;
    if ($.trim(phone.val()) === "") {
      phone.addClass("input-error").siblings(".error").text("Phone number is required");
      valid = false;
    } else if (!phonePattern.test(phone.val().trim())) {
      phone.addClass("input-error").siblings(".error").text("Invalid phone number format");
      valid = false;
    }

    // Validate Message
    const message = $("textarea[name='user_message']");
    if ($.trim(message.val()) === "") {
      message.addClass("input-error").siblings(".error").text("Message is required");
      valid = false;
    }

    if (!valid) {
      e.preventDefault();
    }
  });
});
</script>
    <script src="./script.js" ></script>
    <style>
    .success-msg { color: green; margin-top: 16px; }
    .error-msg { color: red; margin-top: 16px; }
    </style>
  </body>
</html>
