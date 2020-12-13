<?php

//enroll_exam.php // source code modified by jacksonsilass@gmail.com +255 763169695 from weblessons

include('../master/Examination.php');

$_SESSION['start'] = 0 ;
$exam = new Examination;

$exam->user_session_private();

$exam->Change_exam_status($_SESSION['user_id']);

include('../include/user_header.php');

?>
 <meta http-equiv="refresh" content="10">
<br />
<h1 style="align-content: center;padding-top:80px;font-size:50px;font-family:cursive;" align="center">Enrolled Exam</h1><br>

<div class="card">
	<div class="card-header">List of Enrolled exams</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" id="exam_data_table">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Exam Title</th>
						<th>Date & Time</th>
						<th>Duration</th>
						<th>Total Question</th>
						<th>Right Answer Mark</th>
						<th>Wrong Answer Mark</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
</div>
</body>
</html>

<script>

$(document).ready(function(){

	var dataTable = $('#exam_data_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"../user_ajax_action.php",
			type:"POST",
			data:{action:'fetch', page:'enroll_exam'}
		},
		"columnDefs":[
			{
				"targets":[8],
				"orderable":false,
			},
		],
	});

});

</script>