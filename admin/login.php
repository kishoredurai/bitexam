<?php

//login.php 
header("location:/bitexam/student/index.php");

include('Examination.php');

$exam = new Examination;

$exam->admin_session_public();

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
</head>
<body>
<div class="jumbotron text-center" style="margin-bottom:0; padding: 1rem 1rem;background-color:white;">
        <img src="https://www.bitsathy.ac.in/assets/images/headlogo.svg" class="img-fluid" width="900" alt="Online Examination System in PHP">
       
  </div>

 
<link href="../style/button.css" rel="stylesheet" type="text/css">
<hr>
  <div class="container"><br>
	<h1 style="align-content: center;font-size:50px;font-family:cambria;" align="center">Staff Login</h1><br>

      <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-8" style="margin-top:50px;">
          

            <span id="message">
            <?php
            if(isset($_GET['verified']))
            {
              echo '
              <div class="alert alert-success">
                Your email has been verified, now you can login
              </div>
              ';
            }
            ?>   
            </span>
            <div class="card border border-success">
            <div class="card-header"><a style="font-size:180%;">Sign In</a>
                        <div style="float:right; font-size: 40%; position: relative;" ><a href="../master/forgot_password.php" class="btn info">Forgot password?</a></div></div>
              <!-- <div class="card-header" style="font-family:comic sans MS;color:blue;font-size:larger;"><center>Student Login</center></div> -->
              <div class="card-body">
                <form method="post" id="admin_login_form">
                  <div class="form-group">
                    <label style="top:5px;"><b>Email Address : </b></label>
                    <div style="margin-bottom: 25px;top:5px" class="input-group" >
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" name="admin_email_address" id="admin_email_address"placeholder="Email ID" class="form-control" required>
                                                                      
                                    </div>                           
                      <!-- <input type="text" name="user_email_address" id="user_email_address" class="form-control" /> -->
                    </div>
                  <div class="form-group">
                    <label><b>Enter Password : </b></label>
                    <div style="margin-bottom: 15px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" name="admin_password" id="admin_password" class="form-control" placeholder="Password" required>
                                    </div>
                                    
                    <!-- <input type="password" name="user_password" id="user_password" class="form-control" /> -->
                  </div>
                  <div class="input-group">
                                      <div class="checkbox">
                                        <label>
                                          <input id="remember_me" type="checkbox" name="_remember_me" checked value="1"> Remember me
                                        </label>
                                      </div>
                                    </div>
                  <div class="form-group" align="center">
                    <br>
                   
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="login" />
                    <input type="submit" name="user_login" id="admin_login" class="btn success" value=" Login " />&nbsp;
                    <a class="btn blue" href="register.php">Register</a>
                  </div>
                </form>
               
                



                
              </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>
      </div>
  </div>  <br><br>
<style>

  </style>
</body>
</html> 


<script>

$(document).ready(function(){

  $('#admin_login_form').parsley();

  $('#admin_login_form').on('submit', function(event){
    event.preventDefault();

    $('#admin_email_address').attr('required', 'required');

    $('#admin_email_address').attr('data-parsley-type', 'email');

    $('#admin_password').attr('required', 'required');

    if($('#admin_login_form').parsley().validate())
    {
      $.ajax({
        url:"ajax_action.php",
        method:"POST",
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function(){
          $('#admin_login').attr('disabled', 'disabled');
          $('#admin_login').val('please wait...');
        },
        success:function(data)
        {
          if(data.success)
          {
            location.href="index.php";
          }
          else
          {
            $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
          }
          $('#admin_login').attr('disabled', false);
          $('#admin_login').val('Login');
        }
      });
    }

  });

});

</script>