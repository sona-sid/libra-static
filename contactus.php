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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';
    
        // Prepare email
        $to = "sonasidharthan1@gmail.com";
        $email_subject = "New Contact Form Submission: $subject";
        $email_body = "Name: $firstName $lastName\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage:\n$message";
        $headers = "From: $email";
    
        // Send email
        mail($to, $email_subject, $email_body, $headers);
    
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
    
        // Success message
        echo "<script>alert('Thank you for contacting us!');</script>";
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
          <form id="contactForm">
            <div class="form-row">
              <div class="form-group">
                <label>First Name</label>
                <input type="text" placeholder="John"  />
                <span class="error"></span>
              </div>
              <div class="form-group">
                <label>Last Name</label>
                <input type="text" placeholder="Doe"  />
                 <span class="error"></span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Email</label>
                <input
                  type="email"
                  placeholder="your_email@example.com"
                />
                 <span class="error"></span>
              </div>
              <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" placeholder="+1012 3456 789"  />
                 <span class="error"></span>
              </div>
            </div>

            <div class="form-group subject">
              <label>Select Subject?</label>
              <div class="radio-group">
                <label>
                  <input type="radio" name="subject" value="General Inquiry"  checked />
                  <span>General Inquiry</span>
                </label>

                <label>
                  <input type="radio" name="subject" value="Print Inquiry" />
                  <span>Print Inquiry</span>
                </label>

                <label>
                  <input type="radio" name="subject" value="Design Inquiry" />
                  <span>Design Inquiry</span>
                </label>

                <label>
                  <input type="radio" name="subject" value="Branding Inquiry" />
                  <span>Branding Inquiry</span>
                </label>
              </div>
            </div>

            <div class="form-group message">
              <label>Message</label>
              <textarea id="message"  placeholder="Write your message.." ></textarea>
            </div>
            <div class="msg-btn">
              <button type="submit" class="btn-send">Send Message</button>
            </div>
            <div class="letter_send">
              <img src="./assets/images/letter_send.png" />
            </div>
          </form>
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
    <footer id="footer"></footer>
    <script>
      // Load footer.html content
      fetch("footer.html")
        .then((response) => response.text())
        .then((data) => {
          document.getElementById("footer").innerHTML = data;
        });
    </script>
    <script src="./script.js" ></script>
  </body>
</html>
