<?php

//login.php

include('master/Examination.php');

$exam = new Examination;

$exam->user_session_public();


?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="include/logo2.png " type="image/icon type">
  	<title>Online Examination System - datastack</title>
    <link rel="stylesheet" href="style1/dataTables.bootstrap4.min.css">
    <script src="style1/jquery.min.js"></script>
    <script src="style1/parsley.js"></script>

    <script src="https://www.googleapis.com/discovery/v1/apis"></script>
    <meta name="google-signin-client_id" content="89638810968-hpv4ge9br3be84musd50ooa273k6l5up.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <main class="d-flex align-items-center min-vh-100 py-2 py-md-0">
        <div class="container">
            <div class="card login-card">


                <div class="row no-gutters">
                    <div class="col-md-5">
                        <img src="include/login.jpg" alt="login" class="login-card-img">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <div class="brand-wrapper">
                                <img src="https://www.bitsathy.ac.in/assets/images/headlogo.svg" alt="logo" class="logo">
                            </div>
                            <p class="login-card-description"> Sign into your account </p>
                            <form method="post" id="user_login_form">
                                <div class="form-group">
                                    <span id="message">
                                        <?php
                                        if (isset($_GET['verified'])) {
                                            echo '
                                                        <div class="alert alert-success">
                                                            Your email has been verified, now you can login
                                                        </div>
                                                        ';
                                           }
                                        ?>
                                    </span>
                                    <label for="email" class="sr-only">Email</label>
                                    <input class="form-control" id="user_email_address" type="email" name="user_email_address" placeholder="username or email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input id="user_password" type="password" class="form-control" name="user_password" placeholder="password">
                                </div>
                                <input type="hidden" name="page" value="login" />
                                <input type="hidden" name="action" value="login" />
                                <input type="submit" name="user_login" id="user_login" class="btn btn-block login-btn mb-4" value="login" />
                            </form>
                            <div style="padding-left: 130px;font-size: larger;">
                                <p style="font-size: 100%;">-- or -- </p>
                            </div>
                            <div id="my-signin2" style="padding-left: 35px;"></div>
                            <br>
                            <a href="master/forgot_password.php" class="forgot-password-link">Forgot password?</a>
                            <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
                            <hr>
                            <!-- <nav class="login-card-footer-nav">
                                <a href="#!">Terms of use.</a>
                                <a href="#!">Privacy policy</a>
                            </nav> -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
<script>
    $(document).ready(function() {

        $('#user_login_form').parsley();

        $('#user_login_form').on('submit', function(event) {
            event.preventDefault();

            $('#user_email_address').attr('required', 'required');

            $('#user_email_address').attr('data-parsley-type', 'email');

            $('#user_password').attr('required', 'required');

            if ($('#user_login_form').parsley().validate()) {
                $.ajax({
                    url: "user_ajax_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('#user_login').attr('disabled', 'disabled');
                        $('#user_login').val('Please wait...');
                    },
                    success: function(data) {
                       
                        if (data.success) {
                            if (data.status=='staff') {
                            location.href = 'master/index.php';
                            } 
                            if (data.status=='student') {
                            location.href = 'student/index.php';
                             }
                             if (data.status=='coe') {
                            location.href = 'COE/index.php';
                             }
                             if (data.status=='admin') {
                            location.href = 'admin/index.php';
                             }
                        }
                         else {
                            $('#message').html('<div class="alert alert-danger" style="font-size:200;">' + data.error + '</div>');
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

</html>