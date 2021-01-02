<?php

//register.php 

include('Examination.php');

$exam = new Examination;

$exam->admin_session_public();
include('../include/db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Online Examination System in PHP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/guillaumepotier/Parsley.js@2.9.1/dist/parsley.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../style/style.css" />
  <link href="../style/button.css" rel="stylesheet" type="text/css">

</head>

<body>
  <div class="jumbotron text-center" style="margin-bottom:0; padding: 1rem 1rem;background-color:white;">
    <img id="bit_logo" src="https://www.bitsathy.ac.in/assets/images/headlogo.svg" class="img-fluid" width="900" alt="Online Examination System in PHP">

  </div>
  <br><br>
  <div class="container">
    <div class="row">
      <div class="col-md-2">

      </div>
      <div class="col-md-8" style="margin-top:20px;">
        <span id="message"></span>
        <div class="card border border-warning">
          <div class="card-header border border-primary" style="font-size:30px;" align="center">Staff Registration</div>
          <div class="card-body">
            <form method="post" id="admin_register_form">
              <div class="form-group">
                <label><b>Enter Name :</b></label>
                <input type="text" name="admin_name" id="admin_name" class="form-control" />
              </div>
              <div class="form-group">
                <label><b>Enter Email Address :</b></label>
                <input type="text" name="admin_email_address" id="admin_email_address" class="form-control" data-parsley-checkemail data-parsley-checkemail-message='Email Address already Exists' />
              </div>

              <div class="form-group">
                <label><b>Enter Password :</b></label>
                <input type="password" name="admin_password" id="admin_password" class="form-control" />
              </div>
              <div class="form-group">
                <label><b>Enter Confirm Password :</b></label>
                <input type="password" name="confirm_admin_password" id="confirm_admin_password" class="form-control" />
              </div>
              <div class="form-group">
                <label><b>Select Gender : </b></label><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                <label class="radio-inline"><input type="radio" checked="checked" name="admin_gender" id="user_gender" value="Male" style="margin-bottom: 10px">&nbsp;Male</label>&emsp;&emsp;&emsp;
                <label class="radio-inline"><input type="radio" name="admin_gender" id="user_gender" value="Female" style="margin-bottom: 10px">&nbsp;Female </label>

              </div>
              <div class="form-group">
                <label><b>Enter Mobile Number :</b></label>
                <input type="text" name="admin_mobile_no" id="admin_mobile_no" class="form-control" required>
              </div>

              <div class="form-group">
                <label><b>Select Course :</b></label>
                <select name="admin_course" id="admin_course" class="form-control">
                  <?php
                  require_once '../include/db.php';

                  $sql = "SELECT * from course_table ;";
                  $result = mysqli_query($db, $sql);
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                      <option value="<?php echo $row['course_name']; ?>"><?php echo $row['course_name']; ?></option>
                  <?php }
                  } ?>
                </select>
              </div>
              <div class="form-group">
                <label><b>Teacher Level :</b></label>
                <select name="admin_level" id="admin_level" class="form-control">
                  <option value="Assistant Professor Level II">Assistant Professor Level II</option>
                  <option value="Associate Professo">Associate Professor</option>
                  <option value="Professor and Head">Professor and Head</option>
                  <option value="Professor">Professor</option>
                  <option value="Assistant Professor">Assistant Professor</option>

                </select>
              </div>
              <div class="form-group" align="center">
                <input type="hidden" name="page" value="register" />
                <input type="hidden" name="action" value="register" />
                <input type="submit" name="admin_register" id="admin_register" class="btn success" value="Register" />&nbsp;&nbsp;
                <a class="btn blue" href="login.php">Login</a>
              </div>

            </form>

          </div>
        </div>
      </div>
      <div class="col-md-3">

      </div>
    </div>
  </div>
  <br><Br>
</body>

</html>

<script>
  $(document).ready(function() {

    window.ParsleyValidator.addValidator('checkemail', {
      validateString: function(value) {
        return $.ajax({
          url: "ajax_action.php",
          method: "POST",
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

    $('#admin_register_form').parsley();

    $('#admin_register_form').on('submit', function(event) {

      event.preventDefault();

      $('#admin_email_address').attr('required', 'required');

      $('#admin_email_address').attr('data-parsley-type', 'email');

      $('#admin_password').attr('required', 'required');

      $('#admin_name').attr('required', 'required');

      $('#confirm_admin_password').attr('required', 'required');

      $('#confirm_admin_password').attr('data-parsley-equalto', '#admin_password');

      if ($('#admin_register_form').parsley().isValid()) {
        $.ajax({
          url: "ajax_action.php",
          method: "POST",
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function() {
            $('#admin_register').attr('disabled', 'disabled');
            $('#admin_register').val('please wait...');
          },
          success: function(data) {
            if (data.success) {
              $('#message').html('<div class="alert alert-success">Please check your email</div>');
              $('#admin_register_form')[0].reset();
              $('#admin_register_form').parsley().reset();
            }

            $('#admin_register').attr('disabled', false);
            $('#admin_register').val('Register');
          }
        });
      }

    });

  });
</script>