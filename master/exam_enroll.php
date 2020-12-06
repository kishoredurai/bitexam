<?php

//exam_enroll.php // source code modified by jacksonsilass@gmail.com +255 763169695 from weblessons

include('header.php');


?>
<br />
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="exam.php">Exam List</a></li>
    	<li class="breadcrumb-item active" aria-current="page">Exam Enrollment List</li>
  	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Exam Enrollment List</h3>
			</div>
			<div class="col-md-3" align="right">
				
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table id="enroll_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Image</th>
						<th>Name</th>
						<th>Rollno</th>
						<th>Email ID</th>
						<th>Gender</th>
						<th>Attendance</th>
						<th>Exam Intime</th>
						<th>Exam Outtime</th>
						<th>Exam Status</th>
						<th>Remark</th>						
						<th>Result</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>



<script>

$(document).ready(function(){
	var code = "<?php echo $_GET['code']; ?>";

	var dataTable = $('#enroll_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"ajax_action.php",
			type:"POST",
			data:{action:'fetch', page:'exam_enroll', code:code},
		},
		"columnDefs" : [
			{
				"targets" : [0],
				"orderable" : false
			}
		]
	});
});

</script>

<?php

include('footer.php');

?>