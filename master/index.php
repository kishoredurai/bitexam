<?php

//exam.php

include('header.php');


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
$conn = mysqli_connect("localhost", "root", "", "online_examination");
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT `online_exam_title`, `online_exam_datetime`, `online_exam_duration`, `total_question`, `marks_per_right_answer`, `marks_per_wrong_answer` ,`admin_email_address` FROM `online_exam_table`, `admin_table` ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
echo "<tr><td>" . $row["online_exam_title"]. "</td><td>" . $row["online_exam_datetime"] . "</td><td>". $row["online_exam_duration"]. "</td><td>" . $row["total_question"] . "</td><td>" . $row["marks_per_right_answer"] . "</td><td>" . $row["marks_per_wrong_answer"] . "</td><td>" . $row["admin_email_address"] . "</td></tr>";
}
echo "</table>";
} else { echo "0 results"; }
$conn->close();
?>
