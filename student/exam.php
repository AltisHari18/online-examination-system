<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['student_id']) || !isset($_SESSION['exam_id'])) {
    header("Location: ../index.php");
    exit;
}

include "../config/db.php";

$exam_id = $_SESSION['exam_id'];

/* Get exam */
$exam_q = mysqli_query($conn, "SELECT * FROM exams WHERE exam_id='$exam_id'");
if (mysqli_num_rows($exam_q) == 0) {
    die("<h2 style='color:white;text-align:center'>Invalid Exam</h2>");
}
$exam = mysqli_fetch_assoc($exam_q);
$duration = (int)$exam['duration'];

/* Get questions */
$qry = mysqli_query($conn, "SELECT * FROM questions WHERE exam_id='$exam_id'");
$total_questions = mysqli_num_rows($qry);

if ($total_questions == 0) {
    die("<h2 style='color:white;text-align:center'>No questions available for this exam</h2>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Online Exam</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background: linear-gradient(120deg,#667eea,#764ba2);
    min-height:100vh;
}

/* TOP BAR */
.topbar{
    position:sticky;
    top:0;
    background:#ffffff;
    padding:15px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
    z-index:100;
}

/* INFO BOX */
.info-box{
    background:#f1f5ff;
    padding:10px 18px;
    border-radius:25px;
    font-weight:bold;
    color:#333;
}

/* EXAM CONTAINER */
.exam-container{
    max-width:900px;
    margin:30px auto;
    padding:15px;
}

/* QUESTION CARD */
.question-card{
    background:#ffffff;
    border-radius:18px;
    padding:25px;
    margin-bottom:25px;
    box-shadow:0 15px 30px rgba(0,0,0,0.25);
}

/* QUESTION TEXT */
.question-card h4{
    margin-bottom:18px;
    color:#333;
}

/* OPTIONS */
.option{
    display:flex;
    align-items:center;
    padding:14px 18px;
    border-radius:12px;
    border:2px solid #e0e0e0;
    margin-bottom:12px;
    cursor:pointer;
    transition:0.3s;
}
.option:hover{
    background:#f1f5ff;
    border-color:#667eea;
}

/* RADIO */
.option input{
    margin-right:12px;
    accent-color:#667eea;
    transform:scale(1.2);
}

/* SUBMIT BUTTON */
.submit-btn{
    display:block;
    margin:40px auto;
    padding:14px 45px;
    border:none;
    border-radius:30px;
    font-size:18px;
    font-weight:bold;
    background:#1dd1a1;
    color:#fff;
    cursor:pointer;
}
.submit-btn:hover{
    background:#10ac84;
}
</style>

<script>
let timeLeft = <?php echo $duration * 60; ?>;

function startTimer(){
    const timerEl = document.getElementById("timer");
    setInterval(() => {
        let m = Math.floor(timeLeft / 60);
        let s = timeLeft % 60;
        timerEl.innerText = m + ":" + (s < 10 ? "0" : "") + s;
        if(timeLeft <= 0){
            alert("Time up! Exam submitted.");
            document.getElementById("examForm").submit();
        }
        timeLeft--;
    }, 1000);
}

function countAttempted(){
    const set = new Set();
    document.querySelectorAll("input[type=radio]:checked")
        .forEach(r => set.add(r.name));
    document.getElementById("attempted").innerText = set.size;
}

window.onload = startTimer;
</script>

</head>
<body>

<div class="topbar">
    <div class="info-box">
        📝 Attempted: <span id="attempted">0</span> / <?php echo $total_questions; ?>
    </div>
    <div class="info-box">
        ⏱️ Time Left: <span id="timer"></span>
    </div>
</div>

<div class="exam-container">
<form id="examForm" method="post" action="submit_exam.php">

<?php
$qno = 1;
while ($row = mysqli_fetch_assoc($qry)) {
?>
<div class="question-card">
    <h4>Q<?php echo $qno++; ?>. <?php echo $row['question_text']; ?></h4>

    <label class="option">
        <input type="radio" name="answer[<?php echo $row['question_id']; ?>]" value="A" onchange="countAttempted()">
        <?php echo $row['option_a']; ?>
    </label>

    <label class="option">
        <input type="radio" name="answer[<?php echo $row['question_id']; ?>]" value="B" onchange="countAttempted()">
        <?php echo $row['option_b']; ?>
    </label>

    <label class="option">
        <input type="radio" name="answer[<?php echo $row['question_id']; ?>]" value="C" onchange="countAttempted()">
        <?php echo $row['option_c']; ?>
    </label>

    <label class="option">
        <input type="radio" name="answer[<?php echo $row['question_id']; ?>]" value="D" onchange="countAttempted()">
        <?php echo $row['option_d']; ?>
    </label>
</div>
<?php } ?>

<button type="submit" class="submit-btn">Submit Exam</button>

</form>
</div>

</body>
</html>
