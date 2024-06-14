<?php
$dbhostname = "localhost";
$dbusername = "root";
$dbname = "personal_website";
$dbpassword = "0907Tums$";

//connect with database
$mysqli = new mysqli($dbhostname, $dbusername, $databasePassword, $databasename);

// check for the presence of errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}