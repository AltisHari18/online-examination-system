<?php
$conn = mysqli_connect("localhost", "root", "", "online_exam_db");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
