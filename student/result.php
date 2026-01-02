<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php");
    exit;
}

include "../config/db.php";

$student_id = $_SESSION['student_id'];

/* Get latest result of student */
$result_q = mysqli_query($conn, "
    SELECT r.*, s.name, s.register_no, sub.subject_name, sub.year, sub.semester
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN exams e ON r.exam_id = e.exam_id
    JOIN subjects sub ON e.subject_id = sub.subject_id
    WHERE r.student_id = '$student_id'
    ORDER BY r.result_id DESC
    LIMIT 1
");

if (mysqli_num_rows($result_q) == 0) {
    echo "<h3>No result found</h3>";
    exit;
}

$data = mysqli_fetch_assoc($result_q);
$status = ($data['percentage'] >= 40) ? "PASS" : "FAIL";
$status_color = ($status == "PASS") ? "#10ac84" : "#ee5253";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Exam Result</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg,#667eea,#764ba2);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* RESULT CARD */
.result-card{
    background:#ffffff;
    width:750px;
    padding:40px;
    border-radius:25px;
    box-shadow:0 25px 50px rgba(0,0,0,0.3);
}

/* HEADER */
.header{
    text-align:center;
    margin-bottom:30px;
}
.header h2{
    margin:0;
    color:#333;
}
.status{
    display:inline-block;
    margin-top:10px;
    padding:8px 25px;
    border-radius:20px;
    color:#fff;
    font-weight:bold;
    background:<?php echo $status_color; ?>;
}

/* SECTIONS */
.section{
    margin-bottom:25px;
}
.section h3{
    margin-bottom:10px;
    color:#667eea;
    border-left:5px solid #667eea;
    padding-left:10px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:15px;
}

/* BOX */
.box{
    background:#f4f7ff;
    padding:15px;
    border-radius:15px;
}
.box b{
    color:#333;
}

/* SCORE */
.score{
    text-align:center;
    margin:30px 0;
}
.score h1{
    margin:0;
    font-size:50px;
    color:#10ac84;
}
.score p{
    margin:5px 0;
    font-size:18px;
}

/* BUTTONS */
.buttons{
    text-align:center;
    margin-top:30px;
}
.btn{
    display:inline-block;
    margin:10px;
    padding:12px 30px;
    border-radius:25px;
    text-decoration:none;
    font-weight:bold;
    color:#fff;
    transition:0.3s;
}
.pdf{
    background:#ff9f43;
}
.pdf:hover{
    background:#e67e22;
}
.back{
    background:#1dd1a1;
}
.back:hover{
    background:#10ac84;
}
</style>
</head>

<body>

<div class="result-card">

    <div class="header">
        <h2>📊 Examination Result</h2>
        <div class="status"><?php echo $status; ?></div>
    </div>

    <!-- STUDENT DETAILS -->
    <div class="section">
        <h3>Student Details</h3>
        <div class="grid">
            <div class="box"><b>Name:</b> <?php echo $data['name']; ?></div>
            <div class="box"><b>Register No:</b> <?php echo $data['register_no']; ?></div>
        </div>
    </div>

    <!-- EXAM DETAILS -->
    <div class="section">
        <h3>Exam Details</h3>
        <div class="grid">
            <div class="box"><b>Subject:</b> <?php echo $data['subject_name']; ?></div>
            <div class="box"><b>Date:</b> <?php echo $data['exam_date']; ?></div>
            <div class="box"><b>Year:</b> <?php echo $data['year']; ?></div>
            <div class="box"><b>Semester:</b> <?php echo $data['semester']; ?></div>
        </div>
    </div>

    <!-- PERFORMANCE -->
    <div class="section">
        <h3>Performance Summary</h3>
        <div class="grid">
            <div class="box"><b>Total Questions:</b> <?php echo $data['total_questions']; ?></div>
            <div class="box"><b>Correct Answers:</b> <?php echo $data['correct_answers']; ?></div>
            <div class="box"><b>Wrong Answers:</b> <?php echo $data['wrong_answers']; ?></div>
            <div class="box"><b>Unattempted:</b> <?php echo $data['unattempted']; ?></div>
        </div>
    </div>

    <!-- SCORE -->
    <div class="score">
        <h1><?php echo $data['obtained_marks']; ?></h1>
        <p>Marks Obtained</p>
        <p><b>Percentage:</b> <?php echo round($data['percentage'],2); ?>%</p>
    </div>

    <!-- BUTTONS -->
    <div class="buttons">
        <a href="marksheet.php" class="btn pdf">📄 Download Marksheet</a>
        <a href="dashboard.php" class="btn back">🏠 Back to Dashboard</a>
    </div>

</div>

</body>
</html>
