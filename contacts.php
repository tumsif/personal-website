<?php session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $message = $_POST['message'];
  $_SESSION['submitted'] = true;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contacts - Tumsifu lema</title>
  <link rel="stylesheet" href="styles.css" />
</head>

<body>
  <header>
    <ul class="top-nav-container">
      <li><a href="index.html">home</a></li>
      <li><a href="about.html">about</a></li>
      <li><a href="courses.php">courses</a></li>
      <li><a href="cv.html">CV</a></li>
      <li class="active"><a href="contacts.php">contact</a></li>
      <li><a href="register.php">register</a></li>
    </ul>
  </header>
  <main>
    <section class="container content">
      <h1>Contact me</h1>
      <div class="contacts">
        <div class="contact-details">
          <div class="contact-detail">
            <span><img src="icons/telephone-fill.svg" alt="telephone" /></span>
            <div>
              <p class="contact-label">Phone Number</p>
              <p class="contact-value">+255625096530</p>
            </div>
          </div>
          <div class="contact-detail">
            <span><img src="icons/envelope-fill.svg" alt="email" /></span>
            <div>
              <p class="contact-label">Email Address</p>
              <p class="contact-value">tumsiful56@gmail.com</p>
            </div>
          </div>
          <div class="contact-detail">
            <span><img src="icons/geo-alt-fill.svg" alt="location" /></span>
            <div>
              <p class="contact-label">Location</p>
              <p class="contact-value">Magufuli Hostels Daressalaam</p>
            </div>
          </div>
        </div>
        <div class="contact-form">
          <?php
          if ($_SESSION['submitted']) {
            echo "
            <h2>Message sent</h2>
            <p>We will contact you back</p>
            ";
          } else {
            echo "
            <h2>Send me a message</h2>
            <p>Its a good way we can get in touch</p>
            <form class='form-contact' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='post'>
              <input type='text' id='name' name='name' placeholder='Your name' required>
              <input type='email' id='email' name='email' placeholder='Email Address' required>
              <input type='number' id='phone' name='phone' placeholder='Phone number' required>
              <input type='text' id='message' name='message' placeholder='Message' required>
              <button class='btn-green' type='submit'>Send Message</button>
            </form>
            ";
          }
          ?>
        </div>
      </div>
    </section>
  </main>
  <footer>
    <div class="footer-container">
      <div class="footer-links">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="courses.php">Courses</a></li>
          <li><a href="cv.html">CV</a></li>
          <li><a href="contacts.php">Contact</a></li>
        </ul>
      </div>
      <div class="footer-contact">
        <h3>Contact Me</h3>
        <p>Email: tumsiful56@gmail.com</p>
        <p>Phone: +255 753 096 530</p>
        <p></p>
      </div>
      <div class="footer-social">
        <h3>Follow Me</h3>
        <a href="https://www.twitter.com" target="_blank"><span><img src="icons/twitter-x.svg" alt="x logo" /></span>
          Twitter</a>
        <a href="https://www.github.com/tumsif" target="_blank"><span><img src="icons/github.svg"
              alt="github logo" /></span>
          GitHub</a>
        <a href="https://wa.me/255625096530"><span><img src="icons/whatsapp.svg" alt="whatsapp logo" /></span>
          Whastapp</a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2024 Tumsifu. All rights reserved.</p>
    </div>
  </footer>
  <script src="scripts.js"></script>
</body>

</html>