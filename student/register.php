<?php

//register.php 

include('../master/Examination.php');

$exam = new Examination;

$exam->user_session_public();

include('header.php');
include('../include/db.php');	
require_once '../include/db.php';
?>
<hr>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

<link href="../style/button.css" rel="stylesheet" type="text/css">

<div class="containter">
  <div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-6">


      <div class="card " style="margin-top:10px;margin-bottom: 100px;border-color:blue;">
        <div class="card-header border border-succes">
          <h4>User Registration</h4>
        </div>
        <div class="card-body">
          <span id="message"></span>
          <!-- <form  role="form" name="insertrecord" method="post" enctype="multipart/form-data"> -->
          <form method="post" enctype="multipart/form-data" id="user_register_form">
            <div class="form-group">
              <label>Enter Email Address</label>
              <input type="text" name="user_email_address" id="user_email_address" class="form-control" data-parsley-checkemail data-parsley-checkemail-message='Email Address already Exists' />
            </div>
            <div class="form-group">
              <label>Enter Password</label>

              <input type="password" name="user_password" id="user_password" class="form-control" />
            </div>
            <div class="form-group">
              <label>Enter Confirm Password</label>
              <input type="password" name="confirm_user_password" id="confirm_user_password" class="form-control" />
            </div>
            <div class="form-group">
              <label>Enter Name</label>
              <input type="text" name="user_name" id="user_name" class="form-control" />
            </div>
            <div class="form-group">
              <label>Select Gender : </label><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
              <label class="radio-inline"><input type="radio" checked="checked" name="user_gender" id="user_gender" value="Male" style="margin-bottom: 10px">Male</label>
              <label class="radio-inline"><input type="radio" name="user_gender" id="user_gender" value="Female" style="margin-bottom: 10px">Female </label>

            </div>
            <div class="form-group">
              <label>Enter Address</label>
              <textarea name="user_address" id="user_address" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <label>Enter Mobile Number</label>
              <input type="text" name="user_mobile_no" id="user_mobile_no" class="form-control" />
            </div>
            <div class="form-group">
              <label>Enter DOB</label>
              <input type="date" name="user_dob" id="user_mobile_no" class="form-control" />
            </div>
            <div class="form-group">
              <label>Select Year</label>
              <select name="user_year" id="user_year" class="form-control">
                <option value="I">I</option>
                <option value="II">II</option>
                <option value="III">III</option>
                <option value="IV">IV</option>
              </select>
            </div>
    
	
            <div class="form-group">
              <label>Select Course</label>
              <select name="user_course" id="user_course" class="form-control">
<?php 
require_once '../include/db.php';
          
$sql= "SELECT * from course_table ;";
$result = mysqli_query($db, $sql);
if (mysqli_num_rows($result)> 0) {
while($row = mysqli_fetch_assoc($result)) 
{
?>
                <option value="<?php echo $row['course_name'];?>"><?php echo $row['course_name'];?></option>
<?php }} ?>
              </select>
            </div>
            <div class="form-group ">
              <label>Select Profile Image</label>
              <input type="file" accept="image/*" name="user_image" id="user_image" />
            </div>
            <br />
            <div class="form-group" align="center">
              <input type="hidden" name='page' value='register' />
              <input type="hidden" name="action" value="register" />
              <input type="submit" name="user_register" id="user_register" class="btn blue" value="Register" />
              <a href="login.php" class="btn success">Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <br /><br />
    <br /><br />
  </div>
</div>
</div>

</body>

</html>

<script>
  $(document).ready(function() {

    window.ParsleyValidator.addValidator('checkemail', {
      validateString: function(value) {
        return $.ajax({
          url: '../user_ajax_action.php',
          method: 'post',
          data: {
            page: 'register',
            action: 'check_email',
            email: value
          },
          dataType: "json",
          async: false,
          success: function(data) {
            return true;
          }
        });
      }
    });

    $('#user_register_form').parsley();

    $('#user_register_form').on('submit', function(event) {
      event.preventDefault();

      $('#user_email_address').attr('required', 'required');

      $('#user_email_address').attr('data-parsley-type', 'email');

      $('#user_password').attr('required', 'required');

      $('#confirm_user_password').attr('required', 'required');

      $('#confirm_user_password').attr('data-parsley-equalto', '#user_password');

      $('#user_name').attr('required', 'required');

      $('#user_name').attr('data-parsley-pattern', '^[a-zA-Z ]+$');

      $('#user_address').attr('required', 'required');

      $('#user_mobile_no').attr('required', 'required');

      $('#user_mobile_no').attr('data-parsley-pattern', '^[0-9]+$');

      $('#user_year').attr('required', 'required');

      $('#user_course').attr('required', 'required');

      $('#user_image').attr('accept', 'image/*');

      if ($('#user_register_form').parsley().validate()) {
        $.ajax({
          url: '../user_ajax_action.php',
          method: "POST",
          data: new FormData(this),
          dataType: "json",
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('#user_register').attr('disabled', 'disabled');
            $('#user_register').val('please wait...');
          },
          success: function(data) {
            if (data.success) {
              $('#message').html('<div class="alert alert-success">Please check your email</div>');
              $('#user_register_form')[0].reset();
              $('#user_register_form').parsley().reset();
            }

            $('#user_register').attr('disabled', false);

            $('#user_register').val('Register');
          }
        })
      }

    });

  });
</script>