<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php");
    exit;
}

include "../config/db.php";

$year = $_POST['year'];
$semester = $_POST['semester'];
$subject_id = $_POST['subject_id'];

/* Verify subject */
$subject_check = mysqli_query(
    $conn,
    "SELECT * FROM subjects 
     WHERE subject_id='$subject_id'
     AND year='$year'
     AND semester='$semester'"
);

$exam_available = false;

if (mysqli_num_rows($subject_check) > 0) {

    $exam = mysqli_query(
        $conn,
        "SELECT * FROM exams 
         WHERE subject_id='$subject_id'
         AND status='available'"
    );

    if (mysqli_num_rows($exam) == 1) {
        $row = mysqli_fetch_assoc($exam);
        $_SESSION['exam_id'] = $row['exam_id'];
        $exam_available = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Exam Status</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg,#43cea2,#185a9d);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* CARD */
.status-card{
    background:#fff;
    width:420px;
    padding:35px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 20px 40px rgba(0,0,0,0.3);
}

/* ICON */
.icon{
    font-size:60px;
    margin-bottom:20px;
}

/* BUTTONS */
.btn{
    display:inline-block;
    margin:12px;
    padding:12px 28px;
    border-radius:25px;
    text-decoration:none;
    font-weight:bold;
    color:#fff;
    transition:0.3s;
}
.start{
    background:#1dd1a1;
}
.start:hover{
    background:#10ac84;
}
.back{
    background:#576574;
}
.back:hover{
    background:#2f3542;
}

/* TEXT */
h2{
    margin-bottom:10px;
}
p{
    color:#555;
}
</style>
</head>

<body>

<div class="status-card">

<?php if ($exam_available) { ?>

    <div class="icon">✅</div>
    <h2>Exam Available</h2>
    <p>You can start the exam now. Please read instructions carefully.</p>

    <a href="exam.php" class="btn start">Start Exam</a>
    <a href="select_exam.php" class="btn back">Go Back</a>

<?php } else { ?>

    <div class="icon">❌</div>
    <h2>No Exam Available</h2>
    <p>No examination is scheduled for the selected subject.</p>

    <a href="select_exam.php" class="btn back">Go Back</a>

<?php } ?>

</div>

</body>
</html>
