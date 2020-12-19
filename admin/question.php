<?php

//question.php // source code modified by jacksonsilass@gmail.com +255 763169695 from weblessons

include('header.php');



$exam_id = $exam->Get_exam_id($_GET['code']);


include('../include/db.php');
require_once'../include/db.php';

$result = mysqli_query($db,"SELECT count(*) as cnt from question_table WHERE online_exam_id='$exam_id';");
$row=mysqli_fetch_array($result);
$total=$row["cnt"];

?>

<br />
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="exam.php">Exam List</a></li>
    	<li class="breadcrumb-item active" aria-current="page">Question List</li>
  	</ol>
</nav>


<div class="wrapper container">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					<h3 class="panel-title">Question List</h3>
				</div>
				<div class="col-md-3" align="right" style="padding-top:6px;color:blue;">
				<h5 class="panel-title">Total Questions : <?php echo $total ?></h>
				</div>
			</div>
		</div>
		<div class="card-body">
			<span id="message_operation"></span>
			<div class="table-responsive">
				<table id="question_data_table" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th style="max-width: 10%;">S.No</th>
							<th style="max-width: auto;">Question</th>
							<th style="max-width: 15%;">Correct Answer</th>
							<th style="max-width: 20%;">Action</th>
						</tr>
					</thead>
				</table>
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
	              				<label class="col-md-4 text-right">Question<span class="text-danger">*</span></label>
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
	              				<label class="col-md-4 text-right">Option 1 <span class="text-danger">*</span></label>
		              			<div class="col-md-8">
		                			<input type="text" name="option_title_1" id="option_title_1" autocomplete="off" class="form-control" />
		                		</div>
	            			</div>
	          			</div>
	          			<div class="form-group">
	            			<div class="row">
	              				<label class="col-md-4 text-right">Option 2 <span class="text-danger">*</span></label>
		              			<div class="col-md-8">
		                			<input type="text" name="option_title_2" id="option_title_2" autocomplete="off" class="form-control" />
		                		</div>
	            			</div>
	          			</div>
	          			<div class="form-group">
	            			<div class="row">
	              				<label class="col-md-4 text-right">Option 3 <span class="text-danger">*</span></label>
		              			<div class="col-md-8">
		                			<input type="text" name="option_title_3" id="option_title_3" autocomplete="off" class="form-control" />
		                		</div>
	            			</div>
	          			</div>
	          			<div class="form-group">
	            			<div class="row">
	              				<label class="col-md-4 text-right">Option 4 <span class="text-danger">*</span></label>
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
		                				<option value="1">1 Option</option>
		                				<option value="2">2 Option</option>
		                				<option value="3">3 Option</option>
		                				<option value="4">4 Option</option>
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
		          		<input type="hidden" name="action" id="hidden_action" value="Edit" />
		          		<input type="submit" name="question_button_action" id="question_button_action" class="btn btn-success btn-sm" value="Add" />
		          		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
		        	</div>
	        	</div>
	    	</form>
	  	</div>
	</div>
	<!-- delete question -->
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
					<button type="button" name="ok_button" id="ok_button" class="btn-primary btn-sm">OK</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>	
			</div >
		</div>
	</div>
</div>

<script src="./textboxio/textboxio.js"></script>
<script>

$(document).ready(function(){
	
var code = "<?php echo $_GET["code"]; ?>";

var dataTable = $('#question_data_table').DataTable({
	"processing" :true,
	"serverSide" :true,
	"order" :[],
	"ajax" :{
		url:"ajax_action.php",
		method:"POST",
		data:{action:'fetch', page:'question', code:code}
	},
	"columnDefs":[
		{
			"targets" :[2],
			"orderable":false,
		}
	],
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

	function reset_question_form()
	{
		$('#question_button_action').val('Edit');
		$('#question_form')[0].reset();
		$('#question_form').parsley().reset();
	}

	var question_id = '';

	$(document).on('click', '.edit', function(){
		question_id = $(this).attr('id');
		reset_question_form();
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'edit_fetch', question_id:question_id, page:'question'},
			dataType:"json",
			success:function(data)
			{
				editor.content.set(data.question_title);
				$('#question_title').val(data.question_title);
				$('#option_title_1').val(data.option_title_1);
				$('#option_title_2').val(data.option_title_2);
				$('#option_title_3').val(data.option_title_3);
				$('#option_title_4').val(data.option_title_4);
				$('#answer_option').val(data.answer_option);
				$('#question_id').val(question_id);
				$('#question_modal_title').text('Edit Question Details');
				$('#questionModal').modal('show');
			}
		})
	});

	$(document).on('click', '.delete', function(){
		question_id = $(this).attr('id');		
		$('#deleteModal').modal('show');
	});
  
   $('#ok_button').click(function(){
          $.ajax({
   		          url:"ajax_action.php",
                  method:"POST",
   		          data:{question_id:question_id, action:'delete', page:'question'},
                  dataType: "json",
   		          success: function(data)
		        {
  			     $('#message_operation').htm('div class="alert alert-success">'+data.success+'</div>');
   			     $('#deleteModal').modal('hide');
   			       dataType.ajax.reload();
   	         	}
            });
         });
    });      
	var editor = textboxio.replace('.question_textarea');
	// editor.message('info', 3000, 'This editor can be used to add images, mathematical symbols and also you can change font size, font style, etc.');
</script>
<style>
	question_text {
		margin: 10px 0;
		height: 400px !important;
	}
	#ephox_question_text{
		min-height: 50px !important;
	}
	.btn {
		font-size: 0.875rem;
		font-weight: 500;
		width: 140px;
	}
	/* #question_data_table {
		width: 100px;
	} */
	table{
		table-layout: fixed;
		text-align: center;
	}
	td {
		/* border: 1px solid blue; */
		overflow: hidden;
		/* white-space: nowrap; */
		/* text-overflow: ellipsis; */
	}
</style>

<?php

include('footer.php');

?>