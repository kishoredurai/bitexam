<?php

//pdf_exam_result.php 
include("Examination.php");

require_once('../class/pdf.php');

$exam = new Examination;

if(isset($_GET["code"]))
{
	$exam_id = $exam->Get_exam_id($_GET["code"]);

	$exam->query = "SELECT * from online_exam_table where online_exam_id = '$exam_id' ;";

	$results = $exam->query_result();

	$output = '

	<center><img src="../include/bitbanner.png" width="700" height="160" ></center><br>
	<h1 align="center" style="color:blue;">Online Exam Attendance</h1><br />

	<hr>
	';
	foreach($results as $rows)
	{
	$output .= '<h3>Exam Title :&nbsp;&nbsp;&nbsp;&nbsp;'.$rows["online_exam_title"].'<br><b>Exam Date and Time : </b>'.$rows["online_exam_datetime"].'<br><b>Student Year : 
	</b>'.$rows["user_year"].'<br><b>User Course : </b>'.$rows["user_course"].'<br><b>Exam Duration (min): </b>'.$rows["online_exam_duration"];
    }

	$output .= '

	<table width="100%" border="1" cellpadding="5" cellspacing="0">
		<tr>
        <th>S.No</th>
        <th>Image</th>
        <th>Name</th>
        <th>Rollno</th>
        <th>Attendance</th>
        <th>Exam Intime</th>
        <th>Exam Outtime</th>
        <th>Exam Status</th>
        <th>Remark</th>					
		</tr>
	';
	
	$exam->query = "
	SELECT * FROM user_exam_enroll_table 
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_enroll_table.user_id  
			WHERE user_exam_enroll_table.exam_id = '".$exam_id."';
	";

	$result = $exam->query_result();

	$count = 1;

	foreach($result as $row)
	{
		$sample=$row["attendance_status"];
		if($sample=="Absent")
		{
			$output .= '
			<tr>
				<td>'.$count.'</td>
				<td><img src="../upload/'.$row["user_image"].'" width="75" /></td>
				<td>'.$row["user_name"].'</td>
				<td>'.$row["user_rollno"].'</td>
				<td>'.$row["attendance_status"].'</td>
				<td><label style="color:red;">Not Attended</label></td>
				<td>  - </td>
				<td>  incomplete </td>
				<td>  NIL </td>
				
			</tr>
			';
		}
		else
		{
			$output .= '
			<tr>
				<td>'.$count.'</td>
				<td><img src="../upload/'.$row["user_image"].'" width="75" /></td>
				<td>'.$row["user_name"].'</td>
				<td>'.$row["user_rollno"].'</td>
				<td>'.$row["attendance_status"].'</td>
				<td>'.$row["exam_intime"].'</td>
				<td>'.$row["exam_outtime"].'</td>
				<td>'.$row["exam_status"].'</td>
				<td>'.$row["remark"].'</td>
				
			</tr>
			';

		}
		

		$count = $count + 1;
	}

	$output .= '</table>';

	$pdf = new Pdf();

	$file_name = 'Exam Result.pdf';

	$pdf->loadHtml($output);

	$pdf->render();

	$pdf->stream($file_name, array("Attachment" => false));

	exit(0);
}
