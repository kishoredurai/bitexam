<?php

//view_exam.php

include('../master/Examination.php');

$exam = new Examination;

$exam->user_session_private();

include('../include/user_header.php');

$exam_id = '';
$exam_status = '';
$remaining_minutes = '';

if(isset($_GET['code']))
{
	$exam_id = $exam->Get_exam_id($_GET["code"]);
	$exam->query = "
	SELECT online_exam_status, online_exam_datetime, online_exam_duration FROM online_exam_table 
	WHERE online_exam_id = '$exam_id'
	";

	$result = $exam->query_result();

	foreach($result as $row)
	{
		$exam_status = $row['online_exam_status'];
		$exam_star_time = $row['online_exam_datetime'];
		$duration = $row['online_exam_duration'] . ' minute';
		$exam_end_time = strtotime($exam_star_time . '+' . $duration);

		$exam_end_time = date('Y-m-d H:i:s', $exam_end_time);
		$remaining_minutes = strtotime($exam_end_time) - time();
	}
}
else
{
	header('location:enroll_exam.php');
}


?>
<?php

if($exam_status == 'Completed')
{
	$exam->query = "
	SELECT * FROM question_table 
	INNER JOIN user_exam_question_answer 
	ON user_exam_question_answer.question_id = question_table.question_id 
	WHERE question_table.online_exam_id = '$exam_id' 
	AND user_exam_question_answer.user_id = '".$_SESSION["user_id"]."'
	";

	//echo $exam->query;

	$result = $exam->query_result();
?>
<br><br>	<h1 style="align-content: center;font-size:50px;font-family:cursive;" align="center">Online Exam Results</h1><br>
<br><br>
	<div class="card border border-primary">
		<div class="card-header">
			<div class="row">
				<div class="col-md-8" style="font-family:Arial;font-size:28px;">Online Exam Result</div>
				<div class="col-md-4" align="right">
					<a href="pdf_exam_result.php?code=<?php echo $_GET["code"]; ?>" class="btn info btn-sm" target="_blank">PDF</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<tr>
						<th>Question</th>
						<th>Option 1</th>
						<th>Option 2</th>
						<th>Option 3</th>
						<th>Option 4</th>
						<th>Your Answer</th>
						<th>Answer</th>
						<th>Result</th>
						<th>Marks</th>
					</tr>
					<?php
					$total_mark = 0;

					foreach($result as $row)
					{
						$exam->query = "
						SELECT * 
						FROM option_table 
						WHERE question_id = '".$row["question_id"]."'
						";

						$sub_result = $exam->query_result();
						$user_answer = '';
						$orignal_answer = '';
						$question_result = '';

						if($row['marks'] == '0')
						{
							$question_result = '<h4 class="badge badge-dark">Not Attend</h4>';
						}

						if($row['marks'] > '0')
						{
							$question_result = '<h4 class="badge badge-success">Right</h4>';
						}

						if($row['marks'] < '0')
						{
							$question_result = '<h4 class="badge badge-danger">Wrong</h4>';
						}

						echo '
						<tr>
							<td>'.$row['question_title'].'</td>
						';

						foreach($sub_result as $sub_row)
						{
							echo '<td>'.$sub_row["option_title"].'</td>';

							if($sub_row["option_number"] == $row['user_answer_option'])
							{
								$user_answer = $sub_row['option_title'];
							}

							if($sub_row['option_number'] == $row['answer_option'])
							{
								$orignal_answer = $sub_row['option_title'];
							}
						}
						echo '
						<td>'.$user_answer.'</td>
						<td>'.$orignal_answer.'</td>
						<td>'.$question_result.'</td>
						<td>'.$row["marks"].'</td>
					</tr>
						';
					}

					$exam->query = "
					SELECT SUM(marks) as total_mark FROM user_exam_question_answer 
					WHERE user_id = '".$_SESSION['user_id']."' 
					AND exam_id = '".$exam_id."'
					";

					$marks_result = $exam->query_result();

					foreach($marks_result as $row)
					{
					?>
					<tr>
						<td colspan="8" align="right">Total Marks</td>
						<td align="right"><?php echo $row["total_mark"]; ?></td>
					</tr>
					<?php	
					}

					?>
				</table>
			</div>
		</div>
	</div>
<?php
}

?>

</div>
</body>
</html>
