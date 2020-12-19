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
        $user_email_verification = $filesop[6];

        $sql = "insert into user_table(user_email_address,user_name,user_rollno,user_year,user_course,user_image,user_email_verified) values ('$user_email_address','$user_name','$user_rollno','$user_year','$user_course','$user_image','$user_email_verification')";
        $stmt = mysqli_prepare($db, $sql);
		mysqli_stmt_execute($stmt);
		echo '<script>alert("Data Uploaded Succesfully ... !");</script>';

        $c = $c + 1;
	}
	echo "<script>window.location.href='user.php'</script>"; 




}
?>


<br /><br>
<div class="card">
	<div class="card-header" align="center">

		<div class="form-group">
			<div class="cols">
				<form method="post" id="exam_form">
					<div class="row">

						<div class="col-12 col-md-4" >
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
						<div class="col-3">

							<input type="submit" name="button_action" id="button_action" class="btn success btn-sm" value="Search" style="align:right" />&emsp;&emsp;&emsp;&emsp;

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
	<h3 class="panel-title">Student  List</h3>

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





<!-- hover -->
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
              				<label class="col-md-4 text-right">Select  CSV File<span class="text-danger">*</span></label>
	              			<div class="col-md-8">
								<input type="file" name="file" id="file"  class="form-control" accept=".csv" size="150" required>
								
	                		</div>
            			</div>
					  </div>
					  
		
	        	<!-- Modal footer -->
	        	<div class="modal-footer">
					<button type="submit" name="submit" id="button_action"  class="btn btn-success btn-sm"  value="submit">Upload</button>


	          		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
	        	</div>
        	</div>
    	</form>
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
					page: 'user'
				}
			},
			"columnDefs": [{
				"targets": [0, 7],
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


		$('#online_exam_course').attr('required', 'required');

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

	$('#exam_form').on('submit', function(event){
		$('#formModal').modal('hide');
	});

	function reset_form()
	{
		$('#modal_title').text('Add Student Details csv file');
		$('#button_act').val('Add');
		$('#action').val('Add');
		$('#exam_form')[0].reset();
		$('#exam_form').parsley().reset();
	}
	
		$('#add_button').click(function(){
		reset_form();
		$('#formModal').modal('show');
		$('#message_operation').html('');
	});
</script>