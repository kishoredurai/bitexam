<?php

//exam.php 
require_once '../include/db.php';

include('../include/db.php');
include('header.php');


if (isset($_POST['button_action'])) {
	$coursename = $_POST["course"];
	$result = mysqli_query($db, "insert into course_table(course_name) values ('$coursename');");
	echo '<script>alert("Course Added")</script>';
	echo "<script>window.location.href='course.php'</script>";
}

if (isset($_REQUEST['del'])) {
	$courseid = intval($_GET['del']);
	$exam->query = "DELETE FROM course_table WHERE course_id='$courseid';";
	$results = $exam->query_result();
	echo '<script>alert("Course Deleted Successfully")</script>';
	echo "<script>window.location.href='course.php'</script>";
}
?>
<br><br>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Course Table</h3>
			</div>
			<div class="col-md-3" align="right">
				<button type="button" id="add_button" class="btn info btn-sm">Add</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" id="exam_data_table">
				<thead>
					<tr>
						<th>Sn no</th>
						<th>Course ID</th>
						<th>Course Name</th>
						<th>Created Date</th>
					</tr>
				</thead>
				<tbody>
					<?php $exam->query = "SELECT * FROM course_table";

					$result = $exam->query_result();
					$cnt = 0;
					foreach ($result as $row) {
						$cnt++;
					?>
						<tr>
							<td><?php echo $cnt; ?></td>
							<td><?php echo $row['course_id']; ?></td>
							<td><?php echo $row['course_name']; ?></td>
							<td><?php echo $row['create_date']; ?></td>
							<!-- <td><a class="btn danger" href="course.php?del=<?php echo $row['course_id']; ?>">delete</a></td> -->
						</tr>
				</tbody>
			<?php }  ?>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="formModal">
	<div class="modal-dialog modal-lg">
		<form method="post" id="exam_form">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal_title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Course Name <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="course" id="online_exam_title" class="form-control" />

							</div>
						</div>
					</div>

					<!-- Modal footer -->
					<div class="modal-footer">
						<input type="hidden" name="online_exam_id" id="online_exam_id" />

						<input type="hidden" name="page" value="exam" />

						<input type="hidden" name="action" id="action" value="Add" />

						<input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />

						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
					</div>
				</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function() {

		var dataTable = $('#exam_data_table').DataTable({

		});

	});
</script>

<script>
	$(document).ready(function() {



		function reset_form() {
			$('#modal_title').text('Add Exam Details');
			$('#button_action').val('Add');
			$('#action').val('Add');

		}

		$('#add_button').click(function() {
			reset_form();
			$('#formModal').modal('show');
			$('#message_operation').html('');
		});



	});
</script>