<?php

//login.php

    include('../master/Examination.php');

    $exam = new Examination;

    $exam->user_session_public();

include('header.php');

?>
 <!-- google oauth client id -->
 <meta name="google-signin-client_id" content="89638810968-hpv4ge9br3be84musd50ooa273k6l5up.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

<link href="../style/button.css" rel="stylesheet" type="text/css">
<hr>
  <div class="container">
	<h1 style="align-content: center;font-size:50px;font-family:Comic Sans MS;color:blue;" align="center">Online Examination System</h1>

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
            <div class="card-header"><a style="font-size:30px;font-family:cursive;">LOGIN</a>
                        <div style="float:right; font-size: 80%; position: relative;" ><a class="btn btn-link btn-sm" href="../master/forgot_password.php">  Forgot password?  </a></div></div>
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
                  
                  <div class="form-group" align="center">
                    <br>
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="login" />
                    <input type="submit" name="user_login" id="user_login" class="btn success" value="  Login  " />&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="btn blue" href="register.php">Register</a>
                    

                  </div>
                  
                </form>
                <div align="center"><p style="font-size: 150%;">-- or -- </p>
                  <div id="my-signin2"></div></div>
                  <br><Br>
                
              </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>
      </div>
  </div>
  <br><Br>
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
            location.href='../master/index.php';
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
<script>
        function onSuccess(googleUser) {
            var profile = googleUser.getBasicProfile();
            console.log(profile);
            signOut();

            var id_token = googleUser.getAuthResponse().id_token;
            window.location.replace('./verify.php?token=' + id_token);
            console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
        }

        function onFailure(error) {
            console.log(error);
        }

        function renderButton() {
            gapi.signin2.render('my-signin2', {
                'scope': 'profile email',
                'width': 240,
                'height': 50,
                'longtitle': true,
                'theme': 'dark',
                'onsuccess': onSuccess,
                'onfailure': onFailure
            });
        }
    </script>

    <script src=" https://apis.google.com/js/platform.js?onload=renderButton " async defer></script>

    <!-- body END -->

    <!--JavaScript at end of body for optimized loading-->
    <script src="./assets/jquery.js "></script>

    <script>
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            console.log(profile);

            var id_token = googleUser.getAuthResponse().id_token;
            //signing out user after getting id token;
            signOut();
            //redirecting..
            window.location.replace('./verify.php?token=' + id_token);
        }


        function signOut() {
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.disconnect();
            auth2.signOut().then(function() {
                console.log('User signed out.');
            });
        }
    </script>

