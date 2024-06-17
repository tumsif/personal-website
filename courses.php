<?php
require_once "config/db.php";
// fetching data
$listcourses = $mysqli->prepare("SELECT name, code, offering_department, semester_offered, academic_year, course_instructor, results FROM courses");
$listcourses->execute();
$listcourses->store_result();

function filterData($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = filterData($_POST['course_name']);
    $course_code = filterData($_POST['course_code']);
    $department = filterData($_POST['department']);
    $results = filterData($_POST['results']);
    $semester = filterData($_POST['semester']);
    $year = filterData($_POST['year']);
    $course_description = filterData($_POST['course-description']);
    $instructor = filterData($_POST['instructor']);
    $userid = 2;

    $addcourse = $mysqli->prepare("INSERT INTO courses (name, code, short_description, offering_department, semester_offered, academic_year, course_instructor, results, userId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($addcourse == false) {
        die("Sorry an error occurred error code:" . $mysqli->errno);
    }
    $addcourse->bind_param("ssssddsdd", $course_name, $course_code, $course_description, $department, $semester, $year, $instructor, $results, $userid);
    $addcourse->execute();
    header("Location: courses.php");
    $addcourse->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Courses</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <header>
        <ul class="top-nav-container">
            <li><a href="index.html">home</a></li>
            <li><a href="about.html">about</a></li>
            <li class="active"><a href="courses.php">courses</a></li>
            <li><a href="cv.html">CV</a></li>
            <li><a href="contacts.php">contact</a></li>
            <li><a href="register.php">register</a></li>
        </ul>
    </header>

    <main>
        <section class="container content">
            <h1>Courses</h1>
            <div class="courses-container">
                <div class="reg-button-container">
                    <button class="btn btn-green" onclick="showRegisterForm()">Add course</button>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Course name</th>
                                <th>Course code</th>
                                <th>offering department</th>
                                <th>semester</th>
                                <th>academic year</th>
                                <th>instructor</th>
                                <th>results</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($listcourses->num_rows() > 0) {
                                $listcourses->bind_result($courseName, $courseCode, $offeringDept, $semester, $academicYear, $instructor, $results);
                                while ($listcourses->fetch()) {
                                    echo "
                                        <tr>
                                            <td>" . $courseName . "</td>
                                            <td>" . $courseCode . "</td>
                                            <td>" . $offeringDept . "</td>
                                            <td>" . $semester . "</td>
                                            <td>" . $academicYear . "</td>
                                            <td>" . $instructor . "</td>
                                            <td>" . $results . "</td>
                                        </tr>
                                        ";
                                }
                            } else {
                                echo "
                                    <tr>
                                        <td colspan='7' style='text-align: center'>There is no course entered.</td>
                                    </tr>
                                ";
                            }
                            $listcourses->close();
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="register-course" id="register-course">
                    <div class="course-register-heading">
                        <button class="go-back" onclick="hideRegisterForm()"><img src="icons/arrow-left.svg"
                                alt="go back"></button>
                        <h2>Register a course</h2>
                    </div>
                    <div class="course-register-form container">
                        <form class="form-course" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>"
                            method="post">
                            <input type="text" id="course_name" name="course_name" placeholder="course name" required
                                maxlength="30">
                            <input type="text" id="course_code" name="course_code" placeholder="course code" required
                                maxlength="5">
                            <input type="text" id="department" name="department" placeholder="department" required
                                maxlength="20">
                            <input type="text" id="instructor" name="instructor" placeholder="instructor" required
                                maxlength="30">
                            <input type="number" name="results" id="results" placeholder="results" required>
                            <div style="display: flex; align-items: center; column-gap: 10px">
                                <label for="semester">Semester: </label>
                                <select name="semester" id="semester">
                                    <option value="1">1st semester</option>
                                    <option value="2">2nd semester</option>
                                </select>
                            </div>
                            <div style="display: flex; align-items: center; column-gap: 10px">
                                <label for="semester">Year: </label>
                                <select name="year" id="year">
                                    <option value="1">1st year</option>
                                    <option value="2">2nd year</option>
                                    <option value="3">3rd year</option>
                                    <option value="4">4th year</option>
                                    <option value="5">5th year</option>
                                    <option value="6">6th year</option>
                                </select>
                            </div>
                            <textarea name="course-description" id="course-description" placeholder="course description"
                                cols="3" required></textarea>
                            <button class='btn-red' type='reset'>Clear</button>
                            <button class='btn-green' type='submit'>Add course</button>
                        </form>
                    </div>
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

<?php
$mysqli->close();
?>