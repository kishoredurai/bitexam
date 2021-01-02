<?php
include('../master/Examination.php');

$exam = new Examination;

$exam->user_session_private();
$id =$_SESSION["user_id"];
$count = $_POST['count'];
$exam_id = $_POST['exam_id'];
if (isset($_POST['count']))
{
	$exam->query = "UPDATE user_exam_enroll_table SET tab_count = '$count' WHERE user_id = '$id'  AND exam_id = '$exam_id'";

	$exam->execute_query();
}

?>