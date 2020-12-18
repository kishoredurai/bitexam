<?php

//exam.php 

include('header.php');

include('../include/db.php');	


?>
<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title"> <?php echo $row["admin_name"]; ?> Online Exam List</h3>
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
						<th>Student Year</th>
						<th>Student Course</th>
						<th>Duration</th>
						<th>Total Question</th>
						<th>Right Answer Mark</th>
						<th>Wrong Answer Mark</th>
						<th>Status</th>
						<th>Question</th>
						<th>Enrolled student</th>
						<!-- <th>Result</th>
						<th>Action</th> -->
					</tr>
				</thead>
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
              				<label class="col-md-4 text-right">Exam Title <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="online_exam_title" id="online_exam_title" class="form-control" />
								
	                		</div>
            			</div>
					  </div>
					  <div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Exam Year<span class="text-danger">*</span></label>
	              			<div class="col-md-8">
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
					
					  <div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Course : <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="exam_course" id="online_exam_course" class="form-control">
								<?php
							require_once '../include/db.php';
									
							$sql= "SELECT * from course_table";
							$result = mysqli_query($db, $sql);

							if (mysqli_num_rows($result)> 0) {
							while($row = mysqli_fetch_assoc($result)) 
							{ ?>

								<option value="<?php echo $row['course_name'];?>"><?php echo $row['course_name'];?></option>
	                			<?php } } ?>	
	                			</select>
	                		</div>
            			</div>
							</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Exam Date & Time <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="online_exam_datetime" id="online_exam_datetime" class="form-control" readonly />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Exam Duration <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="online_exam_duration" id="online_exam_duration" class="form-control">
									<option value="">Select</option>
									<option value="2">1 Minute</option>
									<option value="3">2 Minute</option>
	                				<option value="6">5 Minute</option>
									<option value="31">30 Minute</option>
									<option value="91">1 Hour 30 Minute</option>
	                				<!-- <option value="61">1 Hour</option>
	                				<option value="121">2 Hour</option>
	                				<option value="181">3 Hour</option> -->
	                			</select>
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Total Question <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
							  <input type="number" name="total_question" id="total_question" min="1" class="form-control"/>

	                			<!-- <select name="total_question" id="total_question" class="form-control">
									<option value="">Select</option>
									<option value="2">2 Question</option>
	                				<option value="5">5 Question</option>
	                				<option value="10">10 Question</option>
	                				<option value="25">25 Question</option>
	                				<option value="50">50 Question</option>
	                				<option value="100">100 Question</option>
	                				<option value="200">200 Question</option>
	                				<option value="300">300 Question</option>
	                			</select> -->
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Marks for Right Answer <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="marks_per_right_answer" id="marks_per_right_answer" class="form-control">
	                				<option value="">Select</option>
	                				<option value="1">+1 Mark</option>
	                				<option value="2">+2 Mark</option>
	                				<option value="3">+3 Mark</option>
	                				<option value="4">+4 Mark</option>
	                				<option value="5">+5 Mark</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Marks for Wrong Answer <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="marks_per_wrong_answer" id="marks_per_wrong_answer" class="form-control">
									<option value="">Select</option>
									<option value="0">0 Mark</option>
	                				
	                			</select>
	                		</div>
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

<div class="modal" id="deleteModal">
  	<div class="modal-dialog">
    	<div class="modal-content">

      		<!-- Modal Header -->
      		<div class="modal-header">
        		<h4 class="modal-title">Delete Confirmation</h4>
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
      		</div>

      		<!-- Modal body -->
      		<div class="modal-body">
        		<h3 align="center">Are you sure you want to remove this?</h3>
      		</div>

      		<!-- Modal footer -->
      		<div class="modal-footer">
      			<button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
        		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>

<div class="modal" id="questionModal">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="question_form">
      		<div class="modal-content">
      			<!-- Modal Header -->
        		<div class="modal-header">
          			<h4 class="modal-title" id="question_modal_title"></h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>

        		<!-- Modal body -->
        		<div class="modal-body">
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Question <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<!-- <input type="text" name="question_title" id="question_title" autocomplete="off" class="form-control" /> -->
								<!-- question -->	
								<textarea id="question_text" autocomplete="off" class="form-control question_textarea" rows="5" cols="30"></textarea>
								<input type="hidden" name="question_title" id="question_title">
	                		</div>
            			</div>
          			</div>

          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Option A <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="option_title_1" id="option_title_1" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Option B <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="option_title_2" id="option_title_2" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Option C <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="option_title_3" id="option_title_3" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Option D <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="option_title_4" id="option_title_4" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Answer <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="answer_option" id="answer_option" class="form-control">
	                				<option value="">Select</option>
	                				<option value="1">A Option</option>
	                				<option value="2">B Option</option>
	                				<option value="3">C Option</option>
	                				<option value="4">D Option</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	        		<input type="hidden" name="question_id" id="question_id" />

	        		<input type="hidden" name="online_exam_id" id="hidden_online_exam_id" />

	        		<input type="hidden" name="page" value="question" />

	        		<input type="hidden" name="action" id="hidden_action" value="Add" />

	        		<input type="submit" name="question_button_action" id="question_button_action" class="btn btn-success btn-sm" value="Add" />

	          		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
	        	</div>
        	</div>
    	</form>
  	</div>
</div>

<script src="./textboxio/textboxio.js"></script>
<script>

$(document).ready(function(){
	
	var dataTable = $('#exam_data_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "ajax_action.php",
			method:"POST",
			data:{action:'fetch', page:'exam'}
		},
		"columnDefs":[
			{
				"targets":[7,8,9],
				"orderable":false,
			},
		],
	});

	function reset_form()
	{
		$('#modal_title').text('Add Exam Details');
		$('#button_action').val('Add');
		$('#action').val('Add');
		$('#exam_form')[0].reset();
		$('#exam_form').parsley().reset();
	}

	$('#add_button').click(function(){
		reset_form();
		$('#formModal').modal('show');
		$('#message_operation').html('');
	});

	var date = new Date();

	date.setDate(date.getDate());

	$('#online_exam_datetime').datetimepicker({
		startDate :date,
		format: 'yyyy-mm-dd hh:ii',
		autoclose:true
	});

	$('#exam_form').parsley();

	$('#exam_form').on('submit', function(event){
		event.preventDefault();

		$('#online_exam_title').attr('required', 'required');

		$('#online_exam_datetime').attr('required', 'required');

		$('#online_exam_duration').attr('required', 'required');

		$('#total_question').attr('required', 'required');

		$('#marks_per_right_answer').attr('required', 'required');

		$('#marks_per_wrong_answer').attr('required', 'required');

		if($('#exam_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#button_action').attr('disabled', 'disabled');
					$('#button_action').val('Validate...');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_form();

						dataTable.ajax.reload();

						$('#formModal').modal('hide');
					}

					$('#button_action').attr('disabled', false);

					$('#button_action').val($('#action').val());
				}
			});
		}
	});

	var exam_id = '';

	$(document).on('click', '.edit', function(){
		exam_id = $(this).attr('id');

		reset_form();

		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'edit_fetch', exam_id:exam_id, page:'exam'},
			dataType:"json",
			success:function(data)
			{
				$('#online_exam_title').val(data.online_exam_title);

				$('#online_exam_datetime').val(data.online_exam_datetime);

				$('#online_exam_year').val(data.online_exam_year);

				$('#online_exam_year').attr('disabled', 'disabled');

				$('#online_exam_course').val(data.online_exam_course);

				$('#online_exam_course').attr('disabled', 'disabled');


				$('#online_exam_duration').val(data.online_exam_duration);

				$('#total_question').val(data.total_question);

				$('#marks_per_right_answer').val(data.marks_per_right_answer);

				$('#marks_per_wrong_answer').val(data.marks_per_wrong_answer);

				$('#online_exam_id').val(exam_id);

				$('#modal_title').text('Edit Exam Details');

				$('#button_action').val('Edit');

				$('#action').val('Edit');

				$('#formModal').modal('show');
			}
		})
	});

	$(document).on('click', '.delete', function(){
		exam_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{exam_id:exam_id, action:'delete', page:'exam'},
			dataType:"json",
			success:function(data)
			{
				$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
				$('#deleteModal').modal('hide');
				dataTable.ajax.reload();
			}
		})
	});

	function reset_question_form()
	{
		$('#question_modal_title').text('Add Question');
		$('#question_button_action').val('Add');
		$('#hidden_action').val('Add');
		$('#question_form')[0].reset();
		$('#question_form').parsley().reset();
	}

	$(document).on('click', '.add_question', function(){
		reset_question_form();
		$('#questionModal').modal('show');
		$('#message_operation').html('');
		exam_id = $(this).attr('id');
		$('#hidden_online_exam_id').val(exam_id);
	});

	$('#question_form').parsley();

	$('#question_form').on('submit', function(event){
		event.preventDefault();
		var editors = textboxio.get('#question_text');
		var content = ''
		editors.forEach(function(ed){
			content = ed.content.get();
		});
		console.log(document.getElementById('question_text'));
		document.getElementById('question_title').value = content;
		
		
		$('#question_title').attr('required', 'required');

		// $('#image_title').attr('required', 'required');

		$('#option_title_1').attr('required', 'required');

		$('#option_title_2').attr('required', 'required');

		$('#option_title_3').attr('required', 'required');

		$('#option_title_4').attr('required', 'required');

		$('#answer_option').attr('required', 'required');
		if($('#question_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#question_button_action').attr('disabled', 'disabled');

					$('#question_button_action').val('Validate...');
				},
				success:function(data)
				{
					if(data.success)
					{   
						alert("Question Added successfully");
						swal("Good job!", "Question added successfully", "success");
						
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_question_form();
						dataTable.ajax.reload();
						$('#questionModal').modal('hide');
					}

					$('#question_button_action').attr('disabled', false);

					$('#question_button_action').val($('#hidden_action').val());
				}
			});
		}
	});

	var editor = textboxio.replace('.question_textarea');
	// editor.message('info', 3000, 'This editor can be used to add images, mathematical symbols and also you can change font size, font style, etc.');
	

});

</script>
<script>
function myFunction() {
  setTimeout(function(), 3000);
}
</script>
<script>
	 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</script>
<style>
	.question_textarea {
	margin:10px 0;
	height:300px !important;
	}
	.btn {
		font-size: 0.875rem;
		font-weight: 500;
		width: 140px;
	}
</style>

<?php

include('footer.php');

?>