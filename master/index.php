<?php

//exam.php

header('location: exam.php');

include('header.php');
include('../include/db.php');
require_once '../include/db.php';

?>

<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Exam Uploaded Details</h3>
			</div>

		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive">
			<table id="exam_data_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>S.No</th>
						<th>Exam Title</th>
						<th>Date & Time</th>
						<th>Duration</th>
						<th>Total Question</th>
						<th>Right Answer Mark</th>
						<th>Wrong Answer Mark</th>
						<th>Uploaded By</th>
					</tr>
				</thead>

		</div>
	</div>
</div>
<?php
if ($row["admin_name"]) {
	$exam->query = "SELECT `online_exam_title`, `online_exam_datetime`, `online_exam_duration`, `total_question`, `marks_per_right_answer`, `marks_per_wrong_answer` ,`admin_email_address` FROM `online_exam_table`, `admin_table` ";
	$results = $exam->query_result();
	$scount = 0;
	foreach ($results as $row) {
		$scount++;
		echo "<tr><td>" . $scount . "</td><td>" . $row["online_exam_title"] . "</td><td>" . $row["online_exam_datetime"] . "</td><td>" . $row["online_exam_duration"] . "</td><td>" . $row["total_question"] . "</td><td>" . $row["marks_per_right_answer"] . "</td><td>" . $row["marks_per_wrong_answer"] . "</td><td>" . $row["admin_email_address"] . "</td></tr>";
	}

	echo "</table>";
}
?>