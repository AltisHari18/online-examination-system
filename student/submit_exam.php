<?php
session_start();
if (!isset($_SESSION['student_id']) || !isset($_SESSION['exam_id'])) {
    header("Location: ../index.php");
    exit;
}

include "../config/db.php";

$student_id = $_SESSION['student_id'];
$exam_id = $_SESSION['exam_id'];
$answers = isset($_POST['answer']) && is_array($_POST['answer']) ? $_POST['answer'] : [];

/* Fetch all questions for this exam */
$qry = mysqli_query($conn, "SELECT question_id, correct_option FROM questions WHERE exam_id='$exam_id'");
$total_questions = mysqli_num_rows($qry);

$correct = 0;
$wrong = 0;
$unattempted = 0;

while ($row = mysqli_fetch_assoc($qry)) {
    $qid = $row['question_id'];
    $correct_option = $row['correct_option'];

    if (isset($answers[$qid])) {
        if ($answers[$qid] == $correct_option) {
            $correct++;
        } else {
            $wrong++;
        }
    } else {
        $unattempted++;
    }
}

/* Marks calculation */
$obtained_marks = $correct;
$total_marks = $total_questions;
$percentage = ($total_marks > 0) ? ($obtained_marks / $total_marks) * 100 : 0;

/* Store result */
mysqli_query($conn, "
    INSERT INTO results 
    (student_id, exam_id, total_questions, correct_answers, wrong_answers, unattempted, obtained_marks, percentage, exam_date)
    VALUES
    ('$student_id', '$exam_id', '$total_questions', '$correct', '$wrong', '$unattempted', '$obtained_marks', '$percentage', CURDATE())
");

/* Prevent reattempt */
unset($_SESSION['exam_id']);
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
    width:450px;
    padding:35px;
    border-radius:22px;
    text-align:center;
    box-shadow:0 25px 50px rgba(0,0,0,0.3);
}

/* ICON */
.icon{
    font-size:60px;
}

/* SCORE */
.score{
    font-size:42px;
    font-weight:bold;
    color:#667eea;
    margin:10px 0;
}

/* STATS */
.stats{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:15px;
    margin:25px 0;
}
.stat{
    background:#f4f7ff;
    padding:15px;
    border-radius:15px;
}
.stat h3{
    margin:5px 0;
    color:#333;
}
.stat p{
    margin:0;
    font-size:14px;
    color:#666;
}

/* PERCENTAGE */
.percent{
    font-size:20px;
    font-weight:bold;
    color:#10ac84;
    margin-top:10px;
}

/* BUTTONS */
.btn{
    display:inline-block;
    margin:12px;
    padding:12px 30px;
    border-radius:25px;
    text-decoration:none;
    font-weight:bold;
    color:#fff;
    transition:0.3s;
}
.dashboard{
    background:#1dd1a1;
}
.dashboard:hover{
    background:#10ac84;
}
.logout{
    background:#ee5253;
}
.logout:hover{
    background:#c0392b;
}
</style>
</head>

<body>

<div class="result-card">
    <div class="icon">🎉</div>
    <h2>Exam Submitted Successfully</h2>

    <div class="score">
        <?php echo $obtained_marks; ?> / <?php echo $total_marks; ?>
    </div>

    <div class="percent">
        Percentage: <?php echo round($percentage, 2); ?>%
    </div>

    <div class="stats">
        <div class="stat">
            <h3><?php echo $correct; ?></h3>
            <p>Correct</p>
        </div>
        <div class="stat">
            <h3><?php echo $wrong; ?></h3>
            <p>Wrong</p>
        </div>
        <div class="stat">
            <h3><?php echo $unattempted; ?></h3>
            <p>Unattempted</p>
        </div>
        <div class="stat">
            <h3><?php echo $total_questions; ?></h3>
            <p>Total Questions</p>
        </div>
    </div>

    <a href="dashboard.php" class="btn dashboard">🏠 Dashboard</a>
    <a href="../logout.php" class="btn logout">🚪 Logout</a>
</div>

</body>
</html>
