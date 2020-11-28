<?php

//login.php

include('../master/Examination.php');

$exam = new Examination;

$exam->user_session_public();

include('header.php');

?>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

<link href="../style/button.css" rel="stylesheet" type="text/css">
<hr>
  <div class="container">

      <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6" style="margin-top:50px;">
          

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
            <div class="card-header">Sign In
                        <div style="float:right; font-size: 80%; position: relative; top:5px;" ><a href="../master/forgot_password.php">Forgot password?</a></div></div>
              <!-- <div class="card-header" style="font-family:comic sans MS;color:blue;font-size:larger;"><center>Student Login</center></div> -->
              <div class="card-body">
                <form method="post" id="user_login_form">
                  <div class="form-group">
                    <label style="top:5px;">Email Address : </label>
                    <div style="margin-bottom: 25px;top:5px" class="input-group" >
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input class="form-control" id="user_email_address" type="email" name="user_email_address" placeholder="username or email" required> 
                                                                      
                                    </div>                           
                      <!-- <input type="text" name="user_email_address" id="user_email_address" class="form-control" /> -->
                    </div>
                  <div class="form-group">
                    <label>Enter Password : </label>
                    <div style="margin-bottom: 15px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input required id="user_password" type="password" class="form-control" name="user_password" placeholder="password">
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
                    <input type="submit" name="user_login" id="user_login" class="btn success" value=" Login " />&nbsp;
                    <a class="btn blue" href="register.php">Register</a>
                  </div>
                </form>
               
                  
                
              </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>
      </div>
  </div>
<style>

  </style>
</body>
</html>

<script>

$(document).ready(function(){

  $('#user_login_form').parsley();

  $('#user_login_form').on('submit', function(event){
    event.preventDefault();

    $('#user_email_address').attr('required', 'required');

    $('#user_email_address').attr('data-parsley-type', 'email');

    $('#user_password').attr('required', 'required');

    if($('#user_login_form').parsley().validate())
    {
      $.ajax({
        url:"../user_ajax_action.php",
        method:"POST",
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function()
        {
          $('#user_login').attr('disabled', 'disabled');
          $('#user_login').val('please wait...');
        },
        success:function(data)
        {
          if(data.success)
          {
            location.href='index.php';
          }
          else
          {
            $('#message').html('<div class="alert alert-danger" style="font-size:200;">'+data.error+'</div>');
          }

          $('#user_login').attr('disabled', false);

          $('#user_login').val('Login');
        }
      })
    }

  });

});

</script>

