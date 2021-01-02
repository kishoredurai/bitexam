<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('../student/header.php');

include('../include/db.php');
require_once '../include/db.php';

require 'vendor/autoload.php';

$ch = 1;

if (isset($_POST['reset'])) {

  $input = $_POST['user_email_address'];
  $result = mysqli_query($db, "SELECT * from admin_table WHERE admin_email_address='$input' OR admin_name='$input';");
  $results = mysqli_query($db, "SELECT * from user_table WHERE user_email_address='$input' OR user_name='$input';");

  if (mysqli_num_rows($result) == 1) {

    $row = mysqli_fetch_array($result);
    $email = $row["admin_email_address"];
    $id = $row["admin_id"];
    $name = $row["admin_name"];
    require 'vendor/autoload.php';
    $mail = new PHPMailer(true);
    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'cloud@bitsathy.ac.in';                     // SMTP username
    $mail->Password   = 'Cloud@987';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('cloud@bitsathy.ac.in', 'Datastack');
    $mail->addAddress($email);

    $body = "password reset verification";

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $body;
    $mail->Body = $message = '<center><img src="https://img.collegedekhocdn.com/media/img/institute/logo/BIT-Tamilnadu-logo_1.png" width="750" height="160" ></center><br>
    <h3 style="font-size:180%;color:black;">Dear <b>' . $name . ',</b></h3><p style="font-size:150%;">          Your Password Reset <a href="http://localhost/examination-application/master/password_change.php?id=' . $id . '">link</a></p>
    <p style="font-size:150%;color:black;"><b>Thank you,</b></p>
	  <p style="font-size:150%;color:black;">BIT Online Examination System</p>';
    $mail->send();
    //   Message();
    echo '<script>alert("Verification Link is send to your Email")</script>';
    echo "<script>window.location.href='../login.php'</script>";
  } else if (mysqli_num_rows($results) == 1) {
    $row = mysqli_fetch_array($results);
    $email = $row["user_email_address"];
    $id = $row["user_id"];
    $name = $row["user_name"];
    require 'vendor/autoload.php';
    $mail = new PHPMailer(true);
    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'cloud@bitsathy.ac.in';                     // SMTP username
    $mail->Password   = 'Cloud@987';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('cloud@bitsathy.ac.in', 'Datastack');
    $mail->addAddress($email);

    $body = "password reset verification";

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $body;
    $mail->Body = $message = '<center><img src="https://img.collegedekhocdn.com/media/img/institute/logo/BIT-Tamilnadu-logo_1.png" width="750" height="160" ></center><br>
    <h3 style="font-size:180%;color:black;">Dear <b>' . $name . ',</b></h3><p style="font-size:150%;">          Your Password Reset <a href="https://accounts.google.com/signin/v2/recoveryidentifier?flowName=GlifWebSignIn&flowEntry=ServiceLogin">link</a></p>
    <p style="font-size:150%;color:black;"><b>Thank you,</b></p>
	  <p style="font-size:150%;color:black;">BIT Online Examination System</p>';
    $mail->send();
    //   Message();
    echo '<script>alert("Verification Link is send to your Email")</script>';
    echo "<script>window.location.href='../login.php'</script>";
  }
  echo '<script>alert("Sorry, Email Id does not exisit")</script>';
}
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

      </span>


      <div class="card border border-success">
        <div class="card-header">Reset Password
        </div>
        <!-- <div class="card-header" style="font-family:comic sans MS;color:blue;font-size:larger;"><center>Student Login</center></div> -->
        <div class="card-body">

          <form method="post" id="user_login_form">
            <div class="form-group">

              <label style="top:5px;">Username or Email Address : </label>
              <div style="margin-bottom: 25px;top:5px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input class="form-control" id="user_email_address" type="email" name="user_email_address" placeholder="username or email" required>

              </div>
              <!-- <input type="text" name="user_email_address" id="user_email_address" class="form-control" /> -->
            </div>

            <div class="form-group" align="center">
              <br>
              <input type="submit" name="reset" class="btn success" value=" Reset " />&nbsp;
              <a class="btn blue" href="../login.php">Back</a>
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