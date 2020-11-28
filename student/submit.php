<?php

include('../master/Examination.php');

$exam = new Examination;

$exam->user_session_private();

include('../include/db.php');
require_once '../include/db.php';

$examid=intval($_GET['id']);
$id = $_SESSION['user_id'];

$sql= "UPDATE user_exam_enroll_table SET exam_status='Completed',attendance_status='Present' WHERE user_id = $id and exam_id= $examid;";
$result = mysqli_query($db, $sql);

header("location:enroll_exam.php");


?>
