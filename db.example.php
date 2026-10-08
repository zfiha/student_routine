<?php

$host = "localhost";
$dbname = "student_routine";
$username = "YOUR_USERNAME";
$password = "YOUR_PASSWORD";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>