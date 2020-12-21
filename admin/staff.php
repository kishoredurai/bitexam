<?php

require_once '../include/db.php';

include('../include/db.php');

include('header.php');

?>

<?php
if (isset($_POST["submit"])) {


	$file = $_FILES['file']['tmp_name'];
	$handle = fopen($file, "r");
	$c = 0;
	while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
		$admin_name = $filesop[0];
		$admin_email_address = $filesop[1];
		$admin_password = $filesop[2];
		$admin_course = $filesop[3];
		$admin_contact = $filesop[4];


		$sql = "insert into admin_table(admin_name,admin_email_address,admin_password,admin_course,admin_contact) values ('$admin_name','$admin_email_address','$admin_password','$admin_course','$admin_contact')";
		$stmt = mysqli_prepare($db, $sql);
		mysqli_stmt_execute($stmt);
		echo '<script>alert("Data Uploaded Succesfully ... !");</script>';

		$c = $c + 1;
	}
	echo "<script>window.location.href='staff.php'</script>";
}
?>



<style type="text/css" media="all">
	.form_table {
		text-align: center;
	}

	.full_width .segment_header {
		text-align: center !important;
	}

	.q {
		float: none;
		display: inline-block;
	}

	table.matrix,
	table.rating_ranking {
		margin-left: auto !important;
		margin-right: auto !important;
	}
</style>
<br /><br>
<div class="card">
	<div class="card-header" align="center">

		<div class="form-group">
			<div class="cols">
				<form method="post" id="exam_form">
					<div class="row">

						<div class="col-12 col-md-4">
							<select name="staff_id" id="online_exam_course" class="form-control">
								<option value="">Select</option>
								<?php
								require_once '../include/db.php';

								$sql = "SELECT * from course_table";
								$result = mysqli_query($db, $sql);

								if (mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) { ?>
										<option value="<?php echo $row['course_name']; ?>"><?php echo $row['course_name']; ?></option>
								<?php }
								} ?>
							</select>
						</div>

						<div class="col-3">
							<input type="submit" name="button_action" id="button_action" class="btn success btn-sm" value="Search" style="align:right" />
							<button type="button" id="add_button" class="btn info btn-sm">Upload</button>

						</div>
					</div>
			</div>

			</form>
		</div>
	</div>
</div>

<br><Br>
<div class="card">
	<div class="card-header" align="center">
		<h3 class="panel-title">Staff List<button type="button" id="add_button" class="btn warning btn-sm float-right">Add</button></h3>
		<div class="form-group">
			<div class="cols">

			</div>
		</div>
	</div>

	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive">
			<div class="col-2 text-right ml-auto">
				<input type="text" name="search" id="search" placeholder="Search" class="form-control" />
			</div>

			<table class="table table-bordered table-striped table-hover" id="user_data_table">
				<thead>
					<tr>
						<th>S.No</th>
						<th>Staff ID</th>
						<th>Email Address </th>
						<th>Department</th>
						<th>Contact</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<div class="modal" id="detailModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">User Details</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body" id="user_details">

			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="formModal">
	<div class="modal-dialog modal-lg">
		<form enctype="multipart/form-data" method="post" role="form" id="exam_form">

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
							<label class="col-md-4 text-right">Select CSV File<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="file" name="file" id="file" class="form-control" accept=".csv" size="150" required>

							</div>
						</div>
					</div>


					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="submit" name="submit" id="button_action" class="btn btn-success btn-sm" value="submit">Upload</button>


						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
					</div>
				</div>
		</form>
	</div>
</div>


<div class="modal" id="detailModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">User Details</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body" id="user_details">

			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {

		var dataTable = $('#user_data_table').DataTable();
		dataTable.destroy();


		dataTable = $('#user_data_table').DataTable({
			"processing": true,
			"serverSide": true,
			"searching": false,

			"order": [],
			"ajax": {
				url: "ajax_action.php",
				type: "POST",

				data: {
					action: 'load',
					page: 'staff'
				}
			},
			"columnDefs": [{
				"targets": [0, 5],
				"orderable": false,
			}, ],

		});


		$("#search").on("keyup", function() {
			console.log('test');
			var value = $("#search").val().toLowerCase();
			$("#user_data_table tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});


		$(document).on('click', '.delete', function() {
			admin_id = $(this).attr('id');
			//$('#deleteModal').modal('show');
			swal({
					title: "Are you sure?",
					text: "Once deleted, you will not be able to recover this imaginary file!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {

						$.ajax({
							url: "ajax_action.php",
							method: "POST",
							data: {
								admin_id: admin_id,
								action: 'delete',
								page: 'staff'
							},
							dataType: "json",
							success: function(data) {
								$('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
								//$('#deleteModal').modal('hide');
								swal("Poof! Your imaginary file has been deleted!", {
									icon: "success",
								});
								dataTable.ajax.reload();
							}
						})

					} else {
						swal("Your imaginary file is safe!");
					}
				});

		});





	});


	$('#exam_form').on('submit', function(event) {
		event.preventDefault();


		$('#online_exam_course').attr('required', 'required');



		if ($('#exam_form').parsley().validate()) {
			var course = $('#online_exam_course').val();



			var dataTable = $('#user_data_table').DataTable();
			dataTable.destroy();


			dataTable = $('#user_data_table').DataTable({
				"processing": true,
				"serverSide": true,
				"searching": false,

				"order": [],
				"ajax": {
					url: "ajax_action.php",
					type: "POST",

					data: {

						course: course,
						action: 'fetch',
						page: 'staff'
					}
				},
				"columnDefs": [{
					"targets": [0, 5],
					"orderable": false,
				}, ],

			});


		}


		$(document).on('click', '.delete', function() {
			admin_id = $(this).attr('id');
			//$('#deleteModal').modal('show');

			swal({
					title: "Are you sure?",
					text: "Once deleted, you will not be able to recover this imaginary file!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {

						$.ajax({
							url: "ajax_action.php",
							method: "POST",
							data: {
								admin_id: admin_id,
								action: 'delete',
								page: 'staff'
							},
							dataType: "json",
							success: function(data) {
								$('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
								//$('#deleteModal').modal('hide');
								swal("Poof! Your imaginary file has been deleted!", {
									icon: "success",
								});

								dataTable.ajax.reload();
							}
						})

					} else {
						swal("Your imaginary file is safe!");
					}
				});

		});

		$(document).on('click', '.details', function() {
			var admin_id = $(this).attr('id');
			$.ajax({
				url: "ajax_action.php",
				method: "POST",
				data: {
					action: 'fetch_data',
					admin_id: admin_id,
					page: 'staff'
				},
				success: function(data) {
					$('#user_details').html(data);
					$('#detailModal').modal('show');
				}
			});
		});

	});


	function reset_form() {
		$('#modal_title').text('Add Student Details csv file');
		$('#button_act').val('Add');
		$('#action').val('Add');
		$('#exam_form')[0].reset();
		$('#exam_form').parsley().reset();
	}

	$('#add_button').click(function() {
		reset_form();
		$('#formModal').modal('show');
		$('#message_operation').html('');
	});
</script>