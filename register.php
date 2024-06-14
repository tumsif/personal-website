<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>register</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <header>
        <ul class="top-nav-container">
            <li><a href="index.html">home</a></li>
            <li><a href="about.html">about</a></li>
            <li><a href="courses.php">courses</a></li>
            <li><a href="cv.html">CV</a></li>
            <li><a href="contacts.php">contact</a></li>
            <li class="active"><a href="register.php">register</a></li>
        </ul>
    </header>

    <main>
        <section class="container content">
            <h1>Register an account</h1>
            <div class="register-form">
                <form class="form-register" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post"
                    enctype="multipart/form-data">
                    <input type="text" id="first_name" name="first_name" placeholder="first name">
                    <input type="text" id="second_name" name="second_name" placeholder="second name">
                    <input type="text" id="surname" name="surname" placeholder="surname">
                    <input type="text" id="username" name="username" placeholder="username">
                    <input type="password" id="password" name="password" placeholder="password">
                    <input type="email" id="email" name="email" placeholder="email">
                    <input type="number" id="phone" name="phone" placeholder="phone number">
                    <input type="text" id="facebook" name="facebook" placeholder="facebook account">
                    <input type="text" id="twitter" name="twitter" placeholder="twitter">
                    <input type="text" id="instagram" name="instagram" placeholder="instagram account">
                    <div class="cv-input">
                        <input type="file" id="cv" name="cv" placeholder="CV attachment" class="cv">
                        <label for="cv" id="cv-label">click here to upload your CV</label>
                        <span><img src="icons/cloud-upload.svg" alt="cv upload"></span>
                    </div>
                    <button class='btn-green' type='submit'>Send Message</button>
                </form>
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
                <a href="https://www.twitter.com" target="_blank"><span><img src="icons/twitter-x.svg"
                            alt="x logo" /></span>
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