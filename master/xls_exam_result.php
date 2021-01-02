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
	<h1 align="center" style="color:blue;">Online Exam Results</h1><br />

	<hr><br>
	';
	foreach($results as $rows)
	{
	$output .= '<h3>Exam Title :&nbsp;&nbsp;&nbsp;&nbsp;'.$rows["online_exam_title"].'<br><b>Exam Date and Time : </b>'.$rows["online_exam_datetime"].'<br><b>Student Year : 
	</b>'.$rows["user_year"].'<br><b>User Course : </b>'.$rows["user_course"].'<br><b>Exam Duration (min): </b>'.$rows["online_exam_duration"].'<br><b>Total Question : </b>'.$rows["total_question"].'<br><br>';
    }

	$output .= '

<hr><br>
	<h2 align="center">Exam Results</h2><br />

	<table width="100%" border="1" cellpadding="5" cellspacing="0">
		<tr>
			<th>Rank</th>
			<th>Image</th>
			<th>User Name</th>
			<th>User Rollno</th>
			<th>Attendance Status</th>
			<th>Marks</th>
		</tr>
	';

	$exam->query = "
	SELECT user_table.user_id, user_table.user_image, user_table.user_rollno, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark  
	FROM user_exam_question_answer  
	INNER JOIN user_table 
	ON user_table.user_id = user_exam_question_answer.user_id 
	WHERE user_exam_question_answer.exam_id = '$exam_id' 
	GROUP BY user_exam_question_answer.user_id 
	ORDER BY total_mark DESC
	";

	$result = $exam->query_result();

	$count = 1;

	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td>'.$count.'</td>
			<td><img src="../upload/'.$row["user_image"].'" width="75" /></td>
			<td>'.$row["user_name"].'</td>
			<td>'.$row["user_rollno"].'</td>
			<td>'.$exam->Get_user_exam_status($exam_id, $row["user_id"]).'</td>
			<td>'.$row["total_mark"].'</td>
		</tr>
		';

		$count = $count + 1;
	}

	$output .= '</table>';

    // $xls=header('Content-Type: application/vnd.ms-excel');
    header('Content-Type: application/vnd.ms-excel');
    
    header('Content-Disposition: attachment; filename=download.xls');
    echo $output;
    // $file_name = 'Exam Result.xls';

	// $xls->loadHtml($output);

	// $xls->render();

	// $xls->stream($file_name, array("Attachment" => false));

	// exit(0);

}
?>
<!-- exam result 22 -->
<!-- <a href="xls_exam_result.php?code=<?php //echo $_GET['code']; ?>" style="background-color:green" class="btn btn-danger btn-sm" target="_blank">EXCEL</a> -->