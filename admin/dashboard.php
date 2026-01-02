<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Teacher Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg,#1e3c72,#2a5298);
    min-height:100vh;
}

/* HEADER */
.header{
    background:#ffffff;
    padding:20px;
    text-align:center;
    box-shadow:0 4px 12px rgba(0,0,0,0.2);
}
.header h2{
    margin:0;
    color:#333;
}
.header p{
    margin-top:5px;
    color:#666;
}

/* DASHBOARD GRID */
.dashboard{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:30px;
    padding:40px;
}

/* CARD */
.card{
    background:#ffffff;
    border-radius:22px;
    padding:30px;
    text-align:center;
    box-shadow:0 18px 35px rgba(0,0,0,0.25);
    transition:0.3s;
}
.card:hover{
    transform:translateY(-10px);
}

/* ICON */
.icon{
    font-size:48px;
    margin-bottom:15px;
}

/* BUTTON */
.card a{
    display:inline-block;
    margin-top:15px;
    padding:12px 28px;
    border-radius:25px;
    text-decoration:none;
    font-weight:bold;
    color:#fff;
    transition:0.3s;
}

/* CARD COLORS */
.manage a{ background:#ff9f43; }
.manage a:hover{ background:#e67e22; }

.question a{ background:#54a0ff; }
.question a:hover{ background:#2e86de; }

.results a{ background:#1dd1a1; }
.results a:hover{ background:#10ac84; }

.logout a{ background:#ee5253; }
.logout a:hover{ background:#c0392b; }

/* FOOTER */
.footer{
    text-align:center;
    color:#fff;
    padding-bottom:15px;
}
</style>
</head>

<body>

<div class="header">
    <h2>Welcome Teacher 👩‍🏫👨‍🏫</h2>
    <p>Online Examination System</p>
</div>

<div class="dashboard">

    <div class="card manage">
        <div class="icon">📘</div>
        <h3>Manage Subjects & Exams</h3>
        <p>Create subjects, semesters, and exams</p>
        <a href="manage_exam.php">Manage</a>
    </div>

    <div class="card question">
        <div class="icon">❓</div>
        <h3>Manage Questions</h3>
        <p>Add, edit, and delete exam questions</p>
        <a href="manage_questions.php">Questions</a>
    </div>

    <div class="card results">
        <div class="icon">📊</div>
        <h3>View Student Results</h3>
        <p>Check results and download reports</p>
        <a href="view_results.php">Results</a>
    </div>

    <div class="card logout">
        <div class="icon">🚪</div>
        <h3>Logout</h3>
        <p>Exit from the system</p>
        <a href="../logout.php">Logout</a>
    </div>

</div>

<div class="footer">
    © Online Examination System
</div>

</body>
</html>
