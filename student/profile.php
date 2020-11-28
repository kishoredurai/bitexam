<?php

//profile.php // source code modified by jacksonsilass@gmail.com +255 763169695 from weblessons

include('../master/Examination.php');

$exam = new Examination;

$exam->user_session_private();

include('../include/user_header.php');

$exam->query = "
	SELECT * FROM user_table 
	WHERE user_id = '".$_SESSION['user_id']."'
";

$result = $exam->query_result();

?>
<br><br>
	<div class="containter">
	<h1 style="align-content: center;font-size:50px;font-family:cursive;" align="center">Profile</h1><br>

		<div class="d-flex justify-content-center">
			<br />
			<span id="message"></span>
			<div class="card border border-success" style="margin-top:20px;margin-bottom: 100px;">
        		<div class="card-body">
        			<form method="post" id="profile_form">
        				<?php
        				foreach($result as $row)
        				{
        				?>
        				<script>
        				$(document).ready(function(){
        					$('#user_gender').val("<?php echo $row["user_gender"]; ?>");
        				});
						</script>
						<div class="form-group">
					      
							<center><img src="../upload/<?php echo $row["user_image"]; ?>" class="img-thumbnail"  width="180" style="border-radius: 100%;" /><br><br></center>
							<label>Select Profile Image - </label>
							<input type="file" name="user_image" id="user_image" accept="image/*" />
					        <input type="hidden" name="hidden_user_image" value="<?php echo $row["user_image"]; ?>" />
					    </div>
					    <div class="form-group">
					        <label>Enter Name</label>
					        <input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $row["user_name"]; ?>" />
					    </div>
					    <div class="form-group">
					        <label>Select Gender</label>
					        <select name="user_gender" id="user_gender" class="form-control">
					          	<option value="Male">Male</option>
					          	<option value="Female">Female</option>
					        </select>
					    </div>
					    <div class="form-group">
					        <label>Enter Address</label>
					        <textarea name="user_address" id="user_address" class="form-control"><?php echo $row["user_address"]; ?></textarea>
					    </div>
					    <div class="form-group">
					        <label>Enter Mobile Number</label>
					        <input type="text" name="user_mobile_no" id="user_mobile_no" class="form-control" value="<?php echo $row["user_mobile_no"]; ?>" />
					    </div>
					    
					    <br />
					    <div class="form-group" align="center">
					        <input type="hidden" name="page" value="profile" />
					        <input type="hidden" name="action" value="profile" />
					        <input type="submit" name="user_profile" id="user_profile" class="btn blue" value="Save" />
					    </div>
					    <?php
						}
					    ?>
          			</form>
        		</div>
      		</div>
      		<br /><br />
      		<br /><br />
		</div>
	</div>

</body>

</html>

<script>

$(document).ready(function(){

	$('#profile_form').parsley();
	
	$('#profile_form').on('submit', function(event){

		event.preventDefault();

		$('#user_name').attr('required', 'required');

		$('#user_name').attr('data-parsley-pattern', '^[a-zA-Z ]+$');

		$('#user_address').attr('required', 'required');

		$('#user_mobile_no').attr('required', 'required');

		$('#user_mobile_no').attr('data-parsley-pattern', '^[0-9]+$');

		//$('#user_image').attr('required', 'required');

		$('#user_image').attr('accept', 'image/*');

		if($('#profile_form').parsley().validate())
		{
			$.ajax({
				url:"../user_ajax_action.php",
				method:"POST",
				data: new FormData(this),
				dataType:"json",
				contentType: false,
				cache: false,
				processData:false,				
				beforeSend:function()
				{
					$('#user_profile').attr('disabled', 'disabled');
					$('#user_profile').val('please wait...');
				},
				success:function(data)
				{
					if(data.success)
					{
						location.reload(true);
					}
					else
					{
						$('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
					}
					$('#user_profile').attr('disabled', false);
					$('#user_profile').val('Save');
				}
			});
		}
	});
});

</script>