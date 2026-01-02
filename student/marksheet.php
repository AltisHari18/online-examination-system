<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php");
    exit;
}

include "../config/db.php";
require("../fpdf/fpdf.php");

$student_id = $_SESSION['student_id'];

/* Fetch latest result */
$q = mysqli_query($conn, "
    SELECT r.*, s.name, s.register_no, sub.subject_name, sub.year, sub.semester
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN exams e ON r.exam_id = e.exam_id
    JOIN subjects sub ON e.subject_id = sub.subject_id
    WHERE r.student_id='$student_id'
    ORDER BY r.result_id DESC
    LIMIT 1
");

$data = mysqli_fetch_assoc($q);
$status = ($data['percentage'] >= 40) ? "PASS" : "FAIL";

/* Create PDF */
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(0, 10, "COLLEGE NAME", 0, 1, "C");

$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 10, "Online Examination System - Marksheet", 0, 1, "C");

$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(50, 8, "Student Name:");
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 8, $data['name'], 1, 1);

$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(50, 8, "Register No:");
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 8, $data['register_no'], 1, 1);

$pdf->Ln(3);

$pdf->Cell(50, 8, "Subject:");
$pdf->Cell(0, 8, $data['subject_name'], 1, 1);

$pdf->Cell(50, 8, "Year / Semester:");
$pdf->Cell(0, 8, $data['year']." / ".$data['semester'], 1, 1);

$pdf->Cell(50, 8, "Exam Date:");
$pdf->Cell(0, 8, $data['exam_date'], 1, 1);

$pdf->Ln(5);

$pdf->Cell(60, 8, "Total Questions:");
$pdf->Cell(0, 8, $data['total_questions'], 1, 1);

$pdf->Cell(60, 8, "Correct Answers:");
$pdf->Cell(0, 8, $data['correct_answers'], 1, 1);

$pdf->Cell(60, 8, "Wrong Answers:");
$pdf->Cell(0, 8, $data['wrong_answers'], 1, 1);

$pdf->Cell(60, 8, "Unattempted:");
$pdf->Cell(0, 8, $data['unattempted'], 1, 1);

$pdf->Ln(3);

$pdf->Cell(60, 8, "Marks Obtained:");
$pdf->Cell(0, 8, $data['obtained_marks'], 1, 1);

$pdf->Cell(60, 8, "Percentage:");
$pdf->Cell(0, 8, round($data['percentage'],2)." %", 1, 1);

$pdf->Cell(60, 8, "Result Status:");
$pdf->Cell(0, 8, $status, 1, 1);

$pdf->Ln(10);
$pdf->Cell(0, 8, "Signature: ____________________", 0, 1, "R");

$pdf->Output("D", "Marksheet.pdf");
