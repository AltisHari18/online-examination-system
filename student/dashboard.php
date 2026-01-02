<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg,#667eea,#764ba2);
    min-height:100vh;
}

/* HEADER */
.header{
    background:#ffffff;
    padding:20px;
    text-align:center;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}
.header h2{
    margin:0;
    color:#333;
}

/* DASHBOARD */
.dashboard{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
    padding:40px;
}

/* CARD */
.card{
    background:#fff;
    border-radius:15px;
    padding:30px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
    transition:0.3s;
}
.card:hover{
    transform:translateY(-8px);
}

/* ICON */
.icon{
    font-size:40px;
    margin-bottom:15px;
}

/* BUTTON */
.card a{
    display:inline-block;
    margin-top:15px;
    padding:10px 20px;
    border-radius:20px;
    text-decoration:none;
    color:white;
    font-weight:bold;
}

/* CARD COLORS */
.exam{ background:#ff9f43; }
.result{ background:#1dd1a1; }
.profile{ background:#54a0ff; }
.logout{ background:#ee5253; }

.exam a{ background:#ff7f00; }
.result a{ background:#10ac84; }
.profile a{ background:#2e86de; }
.logout a{ background:#c0392b; }

.footer{
    text-align:center;
    color:#fff;
    padding-bottom:15px;
}
</style>
</head>

<body>

<div class="header">
    <h2>Welcome Student 👋</h2>
    <p>Online Examination System</p>
</div>

<div class="dashboard">

    <div class="card exam">
        <div class="icon">📝</div>
        <h3>Start Exam</h3>
        <p>Attend available online examinations</p>
        <a href="select_exam.php">Go</a>
    </div>

    <div class="card result">
        <div class="icon">📊</div>
        <h3>View Result</h3>
        <p>Check your exam performance</p>
        <a href="result.php">View</a>
    </div>

    <div class="card profile">
        <div class="icon">👤</div>
        <h3>Profile</h3>
        <p>Student academic information</p>
        <a href="#">Open</a>
    </div>

    <div class="card logout">
        <div class="icon">🚪</div>
        <h3>Logout</h3>
        <p>Exit from the system safely</p>
        <a href="../logout.php">Logout</a>
    </div>

</div>

<div class="footer">
    © Online Examination System
</div>

</body>
</html>
