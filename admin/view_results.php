<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit;
}
include "../config/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Student Results</title>

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

/* CONTAINER */
.container{
    max-width:1100px;
    margin:40px auto;
    background:#ffffff;
    padding:35px;
    border-radius:25px;
    box-shadow:0 25px 50px rgba(0,0,0,0.3);
}

/* FILTER FORM */
.filters{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-bottom:30px;
}
.filters label{
    font-weight:bold;
    color:#333;
}
.select-box{
    position:relative;
}
.select-box select{
    width:100%;
    padding:12px 40px 12px 15px;
    border-radius:12px;
    border:1.5px solid #ccc;
    background:#f4f7ff;
    appearance:none;
    font-size:15px;
}
.select-box::after{
    content:"▾";
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    pointer-events:none;
}

/* BUTTONS */
.btn{
    padding:12px 25px;
    border:none;
    border-radius:25px;
    font-weight:bold;
    cursor:pointer;
    color:#fff;
    transition:0.3s;
}
.view{
    background:#1dd1a1;
}
.view:hover{
    background:#10ac84;
}
.excel{
    background:#27ae60;
    text-decoration:none;
    padding:10px 22px;
    border-radius:22px;
    color:#fff;
    font-weight:bold;
}
.excel:hover{
    background:#1e8449;
}
.dashboard-btn{
    background:#54a0ff;
    text-decoration:none;
    padding:10px 22px;
    border-radius:22px;
    color:#fff;
    font-weight:bold;
    margin-left:15px;
}
.dashboard-btn:hover{
    background:#2e86de;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:25px;
}
thead{
    background:#667eea;
    color:#fff;
}
th, td{
    padding:12px;
    text-align:center;
}
tr:nth-child(even){
    background:#f4f7ff;
}
tr:hover{
    background:#e8ecff;
}

/* STATUS */
.pass{
    color:#10ac84;
    font-weight:bold;
}
.fail{
    color:#ee5253;
    font-weight:bold;
}

/* FOOTER */
.footer{
    text-align:center;
    color:#fff;
    padding:15px;
}
</style>
</head>

<body>

<div class="header">
    <h2>📊 View Student Results</h2>
    <p>Teacher Panel – Online Examination System</p>
</div>

<div class="container">

<form method="get" class="filters">

    <div>
        <label>Year</label>
        <div class="select-box">
            <select name="year" required>
                <option value="">Select Year</option>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
            </select>
        </div>
    </div>

    <div>
        <label>Semester</label>
        <div class="select-box">
            <select name="semester" required>
                <option value="">Select Semester</option>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                <option value="3">Semester 3</option>
                <option value="4">Semester 4</option>
                <option value="5">Semester 5</option>
                <option value="6">Semester 6</option>
            </select>
        </div>
    </div>

    <div>
        <label>Subject</label>
        <div class="select-box">
            <select name="subject_id" required>
                <option value="">Select Subject</option>
                <?php
                $sub = mysqli_query($conn, "SELECT * FROM subjects");
                while ($row = mysqli_fetch_assoc($sub)) {
                    echo "<option value='{$row['subject_id']}'>{$row['subject_name']}</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <div style="align-self:end">
        <button type="submit" class="btn view">View Results</button>
    </div>

</form>

<?php
if (isset($_GET['year'])) {

    $year = $_GET['year'];
    $semester = $_GET['semester'];
    $subject_id = $_GET['subject_id'];

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

    if (mysqli_num_rows($result) == 0) {
        echo "<p>No students found.</p>";
    } else {

        echo "
        <table>
            <thead>
                <tr>
                    <th>Register No</th>
                    <th>Name</th>
                    <th>Marks</th>
                    <th>Percentage</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
        ";

        while ($row = mysqli_fetch_assoc($result)) {
            $status = ($row['percentage'] >= 40) ? "PASS" : "FAIL";
            $class = ($status == "PASS") ? "pass" : "fail";

            echo "
            <tr>
                <td>{$row['register_no']}</td>
                <td>{$row['name']}</td>
                <td>{$row['obtained_marks']}</td>
                <td>{$row['percentage']}%</td>
                <td class='$class'>$status</td>
            </tr>
            ";
        }

        echo "</tbody></table>";

        echo "<br><br>
        <a class='excel' href='export_excel.php?year=$year&semester=$semester&subject_id=$subject_id'>
            ⬇ Download Excel
        </a>

        <a class='dashboard-btn' href='dashboard.php'>
            🏠 Go to Dashboard
        </a>";
    }
}
?>

</div>

<div class="footer">
    © Online Examination System
</div>

</body>
</html>
