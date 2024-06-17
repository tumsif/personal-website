<?php session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // a reusable function to filter the user input
    function filterData($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (
        isset($_POST['first_name']) &&
        isset($_POST['second_name']) &&
        isset($_POST['surname']) &&
        isset($_POST['username']) &&
        isset($_POST['password']) &&
        isset($_POST['email']) &&
        isset($_POST['phone'])
    ) {
        $firstname = filterData($_POST['first_name']);
        $secondname = filterData($_POST['second_name']);
        $surname = filterData($_POST['surname']);
        $username = filterData($_POST['username']);
        $phone = filterData($_POST['phone']);

        // encrypting the password
        $password = filterData($_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // checking if email format is valid
        $email = filterData($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // redirect the user back to register page
            header("Location: register.php");
            exit();
        }

        // Facebook, twitter and intagram accounts are optional
        // so if present store the value to db if absent set it to null

        if (empty($_POST['facebook'])) {
            $facebook = null;
        } else {
            $facebook = filterData($_POST['facebook']);
        }

        if (empty($_POST['twitter'])) {
            $twitter = null;
        } else {
            $twitter = filterData($_POST['twitter']);
        }

        if (empty($_POST['instagram'])) {
            $instagram = null;
        } else {
            $instagram = filterData($_POST['instagram']);
        }

        // uploading the cv file 
        if (($_FILES['cv']['name'] != "")) {
            // Where the file is going to be stored
            $target_dir = "uploads/";
            $file = $_FILES['cv']['name'];
            $path = pathinfo($file);
            $filename = "cvfile" . $path['filename'];
            $ext = $path['extension'];
            $temp_name = $_FILES['cv']['tmp_name'];
            $path_filename_ext = $target_dir . $filename . $username . "." . $ext;
            $path_filename_ext = str_replace(" ", "_", $path_filename_ext);

            // Check if file already exists
            if (file_exists($path_filename_ext)) {
                $_SESSION['cv_file_error'] = "sorry the cv file for this user is already uploaded";
            } else {
                if ($_FILES["cv"]["size"] > 500000) {
                    $_SESSION['cv_file_error'] = "sorry the submitted file is too large";
                    header("Location: register.php");
                    exit();
                } else {
                    move_uploaded_file($temp_name, $path_filename_ext);
                    $cv_file_name = $path_filename_ext;
                }
            }
        }

        // after user input is valid then storing to db
        require_once "config/db.php";
        // first check if user is already registered
        $checkusers = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $checkusers->bind_param("s", $username);
        $checkusers->execute();
        $checkusers->store_result();

        if ($checkusers->num_rows() > 0) {
            $_SESSION['user_registered_error'] = "sorry this user is already registered";
            header("Location: register.php");

            $checkusers->close();
            $mysqli->close();
            exit();
        } else {
            $registerstmt = $mysqli->prepare("INSERT INTO users (first_name, middle_name, surname, username, password, email, mobile, facebook, instagram, twitter, cv_file_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($registerstmt == false) {
                die("prepare failed: " . $mysqli->error);
            }

            $registerstmt->bind_param("sssssssssss", $firstname, $secondname, $surname, $username, $hashed_password, $email, $phone, $facebook, $instagram, $twitter, $cv_file_name);

            if ($registerstmt->execute()) {
                $_SESSION['success_register'] = "new account registered";

                $_SESSION['username'] = $username;
                header("Location: register.php");
            } else {
                $_SESSION['user_registered_error'] = "An error occured in registering";
                header("Location: register.php");
            }

            $registerstmt->close();
            $mysqli->close();
            exit();

        }
    } else {
        // redirect the user back to register page
        $_SESSION['user_registered_error'] = "please fill required filled";
        header("Location: register.php");
        exit();
    }



}

?>



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
            <?php
            if (isset($_SESSION['user_registered_error'])) {
                echo "
                <p class='error-log'>" . $_SESSION['user_registered_error'] . "</p>
                ";
            }
            if (isset($_SESSION['cv_file_error'])) {
                echo "
                <p class='error-log'>" . $_SESSION['cv_file_error'] . "</p>
                ";
            }

            if (isset($_SESSION['success_register'])) {
                echo "
                <p class='success-log'>" . $_SESSION['success_register'] . "</p>
                ";
            }
            ?>
            <div class="register-form">
                <form class="form-register" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post"
                    enctype="multipart/form-data">
                    <input type="text" id="first_name" name="first_name" placeholder="first name" required>
                    <input type="text" id="second_name" name="second_name" placeholder="second name" required>
                    <input type="text" id="surname" name="surname" placeholder="surname" required>
                    <input type="text" id="username" name="username" placeholder="username" required>
                    <input type="password" id="password" name="password" placeholder="password" required>
                    <input type="email" id="email" name="email" placeholder="email" required>
                    <input type="number" id="phone" name="phone" placeholder="phone number" required>
                    <input type="text" id="facebook" name="facebook" placeholder="facebook account">
                    <input type="text" id="twitter" name="twitter" placeholder="twitter">
                    <input type="text" id="instagram" name="instagram" placeholder="instagram account">
                    <div class="cv-input">
                        <input type="file" id="cv" name="cv" placeholder="CV attachment" class="cv">
                        <label for="cv" id="cv-label">click here to upload your CV</label>
                        <span><img src="icons/cloud-upload.svg" alt="cv upload"></span>
                    </div>
                    <button class='btn-green' type='submit'>Register</button>
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