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
		$user_email_address = $filesop[0];
		$user_name = $filesop[1];
		$user_rollno = $filesop[2];
		$user_year = $filesop[3];
		$user_course = $filesop[4];
		$user_image = $filesop[5];
		$user_email_verified = $filesop[6];



		$sql = "insert into user_table(user_email_address,user_name,user_rollno,user_year,user_course,user_image,user_email_verified) values 
		('$user_email_address','$user_name','$user_rollno','$user_year','$user_course','$user_image','$user_email_verified')";
		$stmt = mysqli_prepare($db, $sql);
		mysqli_stmt_execute($stmt);
	}
	echo '<script>alert("Data Uploaded Succesfully ... !");</script>';

	echo "<script>window.location.href='user.php'</script>";
}
?>

<div class="modal" id="user_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post" id="test_form">

				<div class="modal-header">
					<h4 class="modal-title" id="modal_title"></h4>
					<button type="button" class="close" data-dismiss="modal" data-toggle="user_modal" data-target="#user_modal">&times;</button>
				</div>

				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User Name : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="user_name" id="user_name" class="form-control" />

							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User RollNo : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="user_rollno" id="user_rollno" class="form-control" />

							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Year Of Study<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<select name="user_year" id="user_year" class="form-control">
									<option value="">Select</option>
									<option value="I">I</option>
									<option value="II">II</option>
									<option value="III">III</option>
									<option value="IV">IV</option>

								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User Course : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<select name="user_course" id="user_course" class="form-control">
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
						</div>
					</div>


					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Gender <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<select name="user_gender" id="user_gender" class="form-control">
									<option value="Male">Male</option>
									<option value="Female">Female</option>
									<option value="Transgender">Transgender</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User DOB : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="date" name="user_dob" id="user_dob" class="form-control" />
							</div>
						</div>
					</div>


					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User Email Address : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="email" name="user_email_address" id="user_email_address" class="form-control" />

							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User Contact : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="number" name="user_mobile_no" id="user_mobile_no" class="form-control" />
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User Address : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<textarea type="text" name="user_address" id="user_address" class="form-control">
								</textarea>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<input type="hidden" name="user_id" id="user_id" />

						<input type="hidden" name="page" value="user" />

						<input type="hidden" name="action" id="action" value="Add" />

						<input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" data-toggle="user_modal" data-target="#user_modal" value="Add" />

						<button type="button" class="btn btn-danger btn-sm" data-toggle="user_modal" data-target="#user_modal" data-dismiss="modal">Close</button>
					</div>



				</div>
			</form>
		</div>
		<!-- <form method="post" id="exam_form"> -->
		<!-- <div class="modal-content">
			
				<div class="modal-header">
					<h4 class="modal-title" id="modal_title"></h4>
					<button type="button" class="close" data-dismiss="modal" data-toggle="user_modal" data-target="#user_modal">&times;</button>
				</div> -->

		<!-- Modal body -->
		<!-- <div class="modal-body">
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User Name : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="user_name" id="user_name" class="form-control" />

							</div>
						</div>
					</div>


					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User RollNo : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="user_rollno" id="user_rollno" class="form-control" />

							</div>
						</div>
					</div>


					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Year Of Study<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<select name="user_year" id="user_year" class="form-control">
									<option value="">Select</option>
									<option value="I">I</option>
									<option value="II">II</option>
									<option value="III">III</option>
									<option value="IV">IV</option>

								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User Course : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<select name="user_course" id="user_course" class="form-control">
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
						</div>
					</div>


					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Gender <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<select name="online_exam_duration" id="online_exam_duration" class="form-control">
									<option value="Male">Male</option>
									<option value="Female">Female</option>
									<option value="Transgender">Transgender</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User DOB : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="date" name="user_dob" id="user_dob" class="form-control" />
							</div>
						</div>
					</div>


					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User Email Address : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="email" name="user_email_address" id="user_email_address" class="form-control" />

							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User Contact : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="number" name="user_mobile_no" id="user_mobile_no" class="form-control" />
							</div>
						</div>
					</div>


					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">User Address : <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<textarea type="text" name="user_address" id="user_address" class="form-control" >
								</textarea>
							</div>
						</div>
					</div>-->


		<!-- <div class="modal-footer">
						<input type="hidden" name="online_exam_id" id="online_exam_id" />

						<input type="hidden" name="page" value="exam" />

						<input type="hidden" name="action" id="action" value="Add" />

						<input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" data-toggle="user_modal" data-target="#user_modal" value="Add" />

						<button type="button" class="btn btn-danger btn-sm" data-toggle="user_modal" data-target="#user_modal" data-dismiss="modal">Close</button>
					</div> -->
		<!-- </div> -->
		<!-- </form> -->
	</div>
</div>


<br /><br>
<div class="card">
	<div class="card-header">

		<div class="form-group col-lg-11 col-md-11 offset-lg-1 offset-md-1">
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
						<div class="col-12 col-md-4">
							<div class="form-group">
								<div class="col-md-12">
									<select name="exam_year" id="online_exam_year" class="form-control">
										<option value="">Select</option>
										<option value="I">I</option>
										<option value="II">II</option>
										<option value="III">III</option>
										<option value="IV">IV</option>
									</select>
								</div>

							</div>
						</div>
						<div class="col-4 text-center">
							<input type="submit" name="button_action" id="button_action" class="btn success btn-sm" value="Search" />
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
		<h3 class="panel-title">Student List<button type="button" id="user_button" class="btn warning btn-sm float-right">Add</button></h3>

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
						<th>Image</th>
						<th>User Name </th>
						<th>Email Address </th>
						<th>User Rollno</th>
						<th>Year</th>
						<th>Course </th>
						<th>Details</th>
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
				<button type="button" class="close" data-dismiss="modal" data-target="#detailModal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body" id="user_details">

			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" data-target="#detailModal">Close</button>
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
					<button type="button" class="close" data-toggle="formModal" data-target="#formModal" data-dismiss="modal">&times;</button>
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
						<button type="submit" name="submit" id="button_action" class="btn btn-success btn-sm" value="submit" data-toggle="formModal" data-target="#formModal">Upload</button>


						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" data-toggle="formModal" data-target="#formModal">Close</button>
					</div>
				</div>
		</form>
	</div>
</div>



<script>
	function rest_form() {
		$('#modal_title').text('Add Student Details ');
		$('#button_action').val('Add');
		$('#action').val('Add');
		$('#test_form')[0].reset();
		$('#test_form').parsley().reset();

	}

	$('#user_button').click(function() {
		rest_form();
		$('#user_modal').modal('show');
		$('#message_operation').html('');
	});

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
					page: 'user'
				}
			},
			"columnDefs": [{
				"targets": [0, 7],
				"orderable": false,
			}, ],

		});

		function reset_form() {
			$('#modal_title').text('Add Student Details csv file');
			$('#button_action').val('Search');
			$('#action').val('Search');
			$('#exam_form')[0].reset();
			$('#exam_form').parsley().reset();
		}


		$('#add_button').click(function() {
			reset_form();
			$('#formModal').modal('show');
			$('#message_operation').html('');
		});



		$('#test_form').on('submit', function(event) {
			event.preventDefault();

			$('#user_name').attr('required', 'required');

			$('#user_rollno').attr('required', 'required');

			$('#user_year').attr('required', 'required');

			$('#user_course').attr('required', 'required');

			$('#user_gender').attr('required', 'required');

			$('#user_dob').attr('required', 'required');

			$('#user_email_address').attr('required', 'required');

			$('#user_mobile_no').attr('required', 'required');

			$('#user_address').attr('required', 'required');

			if ($('#test_form').parsley().validate()) {
				$.ajax({
					url: "ajax_action.php",
					method: "POST",
					data: $(this).serialize(),
					dataType: "json",
					beforeSend: function() {
						$('#button_action').attr('disabled', 'disabled');
						$('#button_action').val('Validate...');
						swal("Good job!", " Successfully! Done", "success");
					},
					success: function(data) {
						if (data.success) {
							$('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
							alert("done");
							//rest_form();

							dataTable.ajax.reload();

							$('#user_modal').modal('hide');
						}

						$('#button_action').attr('disabled', false);

						$('#button_action').val($('#action').val());
					}
				});
			}
		});


		var user_id = '';

		$(document).on('click', '.edit', function() {
			user_id = $(this).attr('id');

			rest_form();

			$.ajax({
				url: "ajax_action.php",
				method: "POST",
				data: {
					action: 'edit_fetch',
					user_id: user_id,
					page: 'user'
				},
				dataType: "json",
				success: function(data) {
					$('#user_name').val(data.user_name);

					$('#user_rollno').val(data.user_rollno);

					$('#user_year').val(data.user_year);

					$('#user_course').val(data.user_course);

					$('#user_gender').val(data.user_gender);

					$('#user_dob').val(data.user_dob);

					$('#user_email_address').val(data.user_email_address);

					$('#user_mobile_no').val(data.user_mobile_no);

					$('#user_address').val(data.user_address);

					$('#user_id').val(user_id);

					$('#modal_title').text('Edit User Details');

					$('#button_action').val('Edit');

					$('#action').val('Edit');

					

					$('#user_modal').modal('show');
				}
			})
		});








		$(document).on('click', '.delete', function() {
			user_id = $(this).attr('id');
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
								user_id: user_id,
								action: 'delete',
								page: 'user'
							},
							dataType: "json",
							success: function(data) {
								$('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
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



		$("#search").on("keyup", function() {
			console.log('test');
			var value = $("#search").val().toLowerCase();
			$("#user_data_table tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});


		$(document).on('click', '.details', function() {
			var user_id = $(this).attr('id');
			$.ajax({
				url: "ajax_action.php",
				method: "POST",
				data: {
					action: 'fetch_data',
					user_id: user_id,
					page: 'user'
				},
				success: function(data) {
					$('#user_details').html(data);
					$('#detailModal').modal('show');
				}
			});
		});



	});


	$('#exam_form').on('submit', function(event) {
		event.preventDefault();


		$('#online_staff_id').attr('required', 'required');

		$('#online_exam_year').attr('required', 'required');

		if ($('#exam_form').parsley().validate()) {
			var course = $('#online_exam_course').val();
			var year = $('#online_exam_year').val();


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
						year: year,
						course: course,
						action: 'fetch',
						page: 'user'
					}
				},
				"columnDefs": [{
					"targets": [0, 7],
					"orderable": false,
				}, ],

			});


		}



		$(document).on('click', '.delete', function() {
			user_id = $(this).attr('id');
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
								user_id: user_id,
								action: 'delete',
								page: 'user'
							},
							dataType: "json",
							success: function(data) {
								$('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
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
			var user_id = $(this).attr('id');
			$.ajax({
				url: "ajax_action.php",
				method: "POST",
				data: {
					action: 'fetch_data',
					user_id: user_id,
					page: 'user'
				},
				success: function(data) {
					$('#user_details').html(data);
					$('#detailModal').modal('show');
				}
			});
		});




	});
</script>