<?php

//exam.php 

include('header.php');


?>
<br ><br>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Course Table</h3>
			</div>
			<div class="col-md-3" align="right">
				<!-- <button type="button" id="add_button" class="btn btn-info btn-sm">Add</button> -->
			</div>
		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive">
			<table id="exam_data_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Course ID</th>
						<th>Course Name</th>
						<th>Created Date</th>
					
					</tr>
                </thead>
                <tbody>
                    <?php $exam->query = "SELECT * FROM course_table";

$result = $exam->query_result();

foreach($result as $row)
{
?>
                <tr>
                <td><?php echo $row['course_id'];?></td>
				<td><?php echo $row['course_name'];?></td>
                <td><?php echo $row['create_date'];?></td>
                </tr>
                </tbody>
                <?php }  ?>
			</table>
		</div>
	</div>
</div>

<!-- <div class="modal" id="formModal">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="exam_form">
      		<div class="modal-content"> -->
      			<!-- Modal Header -->
        		<!-- <div class="modal-header">
          			<h4 class="modal-title" id="modal_title"></h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div> -->

        		<!-- Modal body -->
        		<!-- <div class="modal-body">
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
	                				<option value="61">1 Hour</option>
	                				<option value="121">2 Hour</option>
	                				<option value="181">3 Hour</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Total Question <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="total_question" id="total_question" class="form-control">
									<option value="">Select</option>
									<option value="2">2 Question</option>
	                				<option value="5">5 Question</option>
	                				<option value="10">10 Question</option>
	                				<option value="25">25 Question</option>
	                				<option value="50">50 Question</option>
	                				<option value="100">100 Question</option>
	                				<option value="200">200 Question</option>
	                				<option value="300">300 Question</option>
	                			</select>
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
	                				<option value="1">-1 Mark</option>
	                				<option value="1.25">-1.25 Mark</option>
	                				<option value="1.50">-1.50 Mark</option>
	                				<option value="2">-2 Mark</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
        		</div> -->

	        	<!-- Modal footer -->
	        	<!-- <div class="modal-footer">
	        		<input type="hidden" name="online_exam_id" id="online_exam_id" />

	        		<input type="hidden" name="page" value="exam" />

	        		<input type="hidden" name="action" id="action" value="Add" />

	        		<input type="submit" name="button_action" id="button_action" class="btn success btn-sm" value="Add" />

	          		<button type="button" class="btn danger btn-sm" data-dismiss="modal">Close</button>
	        	</div>
        	</div>
    	</form>
  	</div>
</div> -->


<script>

$(document).ready(function(){
	
	

	function reset_form()
	{
        $('#modal_title').text('Add Exam Details');
		$('#button_action').val('Add');
		$('#action').val('Add');

	}

	$('#add_button').click(function(){
		reset_form();
		$('#formModal').modal('show');
		$('#message_operation').html('');
	});



});

</script>
