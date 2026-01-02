<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php");
    exit;
}
include "../config/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Start Exam</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background: linear-gradient(120deg,#89f7fe,#66a6ff);
    min-height:100vh;
}

/* HEADER */
.header{
    background:#ffffff;
    padding:20px;
    text-align:center;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
}
.header h2{
    margin:0;
    color:#333;
}

/* CONTAINER */
.container{
    max-width:800px;
    margin:40px auto;
    background:#ffffff;
    border-radius:20px;
    padding:40px;
    box-shadow:0 20px 40px rgba(0,0,0,0.2);
}

/* STEPS */
.steps{
    display:flex;
    justify-content:space-between;
    margin-bottom:30px;
}
.step{
    flex:1;
    text-align:center;
    color:#555;
}
.step span{
    display:inline-block;
    width:35px;
    height:35px;
    line-height:35px;
    border-radius:50%;
    background:#66a6ff;
    color:#fff;
    margin-bottom:10px;
}

/* FORM LABEL */
label{
    display:block;
    margin:15px 0 6px;
    font-weight:bold;
    color:#444;
}

/* MODERN SELECT */
.select-box{
    position:relative;
    margin-bottom:15px;
}
.select-box select{
    width:100%;
    padding:14px 45px 14px 15px;
    font-size:16px;
    border-radius:12px;
    border:1.5px solid #dcdcdc;
    background:#f9faff;
    color:#333;
    outline:none;
    appearance:none;
    -webkit-appearance:none;
    cursor:pointer;
    transition:0.3s;
}
.select-box select:hover{
    border-color:#66a6ff;
}
.select-box select:focus{
    border-color:#66a6ff;
    box-shadow:0 0 0 3px rgba(102,166,255,0.25);
}
.select-box::after{
    content:"▾";
    position:absolute;
    right:18px;
    top:50%;
    transform:translateY(-50%);
    font-size:18px;
    color:#666;
    pointer-events:none;
}

/* BUTTONS */
.btn-group{
    display:flex;
    justify-content:space-between;
    margin-top:30px;
}
button{
    padding:12px 25px;
    border:none;
    border-radius:25px;
    font-size:16px;
    cursor:pointer;
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

/* INFO BOX */
.info{
    margin-top:25px;
    background:#f1f5ff;
    padding:20px;
    border-left:5px solid #66a6ff;
    border-radius:10px;
    color:#333;
}
</style>
</head>

<body>

<div class="header">
    <h2>📝 Start Your Exam</h2>
    <p>Select your academic details</p>
</div>

<div class="container">

    <div class="steps">
        <div class="step"><span>1</span>Year</div>
        <div class="step"><span>2</span>Semester</div>
        <div class="step"><span>3</span>Subject</div>
    </div>

    <form method="post" action="check_exam.php">

        <label>Select Year</label>
        <div class="select-box">
            <select name="year" required>
                <option value="">-- Choose Year --</option>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
            </select>
        </div>

        <label>Select Semester</label>
        <div class="select-box">
            <select name="semester" required>
                <option value="">-- Choose Semester --</option>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                <option value="3">Semester 3</option>
                <option value="4">Semester 4</option>
                <option value="5">Semester 5</option>
                <option value="6">Semester 6</option>
            </select>
        </div>

        <label>Select Subject</label>
        <div class="select-box">
            <select name="subject_id" required>
                <option value="">-- Choose Subject --</option>
                <?php
                $sub = mysqli_query($conn,"SELECT * FROM subjects");
                while($row = mysqli_fetch_assoc($sub)){
                    echo "<option value='{$row['subject_id']}'>
                            {$row['subject_name']} (Y{$row['year']} S{$row['semester']})
                          </option>";
                }
                ?>
            </select>
        </div>

        <div class="btn-group">
            <a href="dashboard.php">
                <button type="button" class="back">⬅ Back</button>
            </a>
            <button type="submit" class="start">Check Exam ➜</button>
        </div>

    </form>

    <div class="info">
        ⏱️ Exam starts only if it is available.<br>
        ⚠️ Once started, timer cannot be paused.
    </div>

</div>

</body>
</html>
