<?php

//profile.php // source code modified by jacksonsilass@gmail.com +255 763169695 from weblessons

include('../master/Examination.php');

$exam = new Examination;

$exam->user_session_private();

include('../include/user_header.php');

require_once'../include/db.php';

include('../include/db.php');

$exam->query = "
	SELECT * FROM user_table 
	WHERE user_id = '".$_SESSION['user_id']."'
";

$result = $exam->query_result();
$image=$row["user_image"];
?>
<br><br><Br><br>
<h1 style="align-content: center;font-size:50px;font-family:cursive;" align="center">Profile</h1>


<div class="container bootstrap snippet"><div class="card border border-success" style="margin-top:50px;margin-bottom: 100px;">
        		<div class="card-body">
    <div class="row">
  		<div class="col-sm-4"><h1 align ="center" style="font-size:35px;">Profile Dashboard</h1></div>
    	<!-- <div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class="img-circle img-responsive"  width="50%" src="https://upload.wikimedia.org/wikipedia/en/7/77/Bannari_Amman_Institute_of_Technology_logo.png"></a></div> -->
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->
              

      <div class="text-center">
        <img src="../upload/<?php echo $row["user_image"];?>" class="avatar img-circle img-thumbnail" alt="avatar" width="200" style="border-radius: 10%;">
       
      </div></hr><br>
      <ul class="list-group">
            <!-- <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li> -->
            <li class="list-group-item"><center><strong  style="color:blue;font-size:#425af5"><?php echo $row["user_name"]; ?></strong></center></li>
            <!-- <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span> 13</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> 37</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> 78</li> -->
          </ul> 
        </div><!--/col-3-->
    	<div class="col-sm-9">
                         <hr>
          <div class="tab-content">
            <div class="tab-pane active" id="home">
            <?php
        				foreach($result as $row)
        				{
        				?>
        				<script>
        				$(document).ready(function(){
        					$('#user_gender').val("<?php echo $row["user_gender"]; ?>");
        				});
						</script>
        			<form method="post" id="profile_form">
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="first_name"><h4>Full Name</h4></label>
                              <input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $row["user_name"]; ?>" />
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                            <label for="last_name"><h4>Roll No  </h4></label>
					        <input type="text"  class="form-control" value="<?php echo $row["user_rollno"]; ?>" disabled>
                          </div>
                      </div>
          
                      <div class="form-group">
                          <div class="col-xs-6">
                             <label for="mobile"><h4>Year</h4></label>
                             <input type="text"  class="form-control" value="<?php echo $row["user_year"]; ?>" disabled>
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="email"><h4>Course</h4></label>
                              <input type="text"  class="form-control" value="<?php echo $row["user_course"]; ?>" disabled>
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="email"><h4>Gender</h4></label>
                        
					        <select name="user_gender" id="user_gender" class="form-control">
					          	<option value="Male">Male</option>
					          	<option value="Female">Female</option>
					        </select>
						
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="password"><h4>Date Of Birth</h4></label>
                              <input type="date" name="user_dob" id="user_dob" class="form-control" value="<?php echo $row["user_dob"]; ?>" />                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                            <label for="password2"><h4>Address</h4></label>
					        <textarea name="user_address" id="user_address" class="form-control"><?php echo $row["user_address"]; ?></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                            <label for="password2"><h4>Mobile Number</h4></label>
					        <input type="text" name="user_mobile_no" id="user_mobile_no" class="form-control" value="<?php echo $row["user_mobile_no"]; ?>" />
                          </div>
                      </div>
                      <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                                <input type="hidden" name="page" value="profile" />
					        <input type="hidden" name="action" value="profile" />
					        <center><input type="submit" align="center" name="user_profile" id="user_profile" class="btn success" value="Save" /></center>
                            </div>
                      </div>
              	</form>
              
              <hr>
              
             </div><!--/tab-pane-->
             
          </div><!--/tab-content-->

        </div><!--/col-9-->
    </div><!--/row-->
                                                      
    </div>  </div>
</body>

</html>
<?php } ?>
<script>

$(document).ready(function(){

	$('#profile_form').parsley();
	
	$('#profile_form').on('submit', function(event){

		event.preventDefault();

		$('#user_name').attr('required', 'required');

		$('#user_name').attr('data-parsley-pattern', '^[a-zA-Z ]+$');

		$('#user_address').attr('required', 'required');
		$('#user_dob').attr('required', 'required');

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