<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit;
}

include "../config/db.php";

$year = $_GET['year'];
$semester = $_GET['semester'];
$subject_id = $_GET['subject_id'];

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=student_results.csv");

echo "Register No,Name,Marks,Percentage,Status\n";

$result = mysqli_query($conn, "
    SELECT s.register_no, s.name, r.obtained_marks, r.percentage
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN exams e ON r.exam_id = e.exam_id
    JOIN subjects sub ON e.subject_id = sub.subject_id
    WHERE sub.year='$year'
    AND sub.semester='$semester'
    AND sub.subject_id='$subject_id'
");

while ($row = mysqli_fetch_assoc($result)) {
    $status = ($row['percentage'] >= 40) ? "PASS" : "FAIL";
    echo "{$row['register_no']},{$row['name']},{$row['obtained_marks']},{$row['percentage']}%,$status\n";
}
?>
