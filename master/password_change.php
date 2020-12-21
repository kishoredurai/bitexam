<?php


include('header.php');
require_once '../include/db.php';

include('../include/db.php');

if (isset($_POST['change'])) {

  $userid = intval($_GET['id']);

  $passwd = $_POST['password'];
  $conf_passwd = $_POST['confirm_password'];

  if ($passwd == $conf_passwd) {
    $passwd = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $result = mysqli_query($db, "UPDATE `admin_table` SET `admin_password`='$passwd' WHERE admin_id='$userid';");
    echo '<script>alert("Password Changed")</script>';
    echo "<script>window.location.href='../login.php'</script>";
  } else {
    echo '<script>alert("Password Does not match")</script>';
  }
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
              <label style="top:5px;">Password : </label>
              <div style="margin-bottom: 25px;top:5px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input class="form-control" id="user_email_address" type="text" name="password" placeholder="username or email" required>

              </div>
              <!-- <input type="text" name="user_email_address" id="user_email_address" class="form-control" /> -->
            </div>
            <div class="form-group">
              <label>Confirm Password : </label>
              <div style="margin-bottom: 15px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input requiredtype="text" class="form-control" name="confirm_password" placeholder="Confirm password">
              </div>

              <!-- <input type="password" name="user_password" id="user_password" class="form-control" /> -->
            </div>

            <div class="form-group" align="center">
              <br>
              <input type="submit" name="change" id="user_login" class="btn success" value=" Update " />&nbsp;
              <a class="btn blue" href="login.php">Back</a>
            </div>
          </form>



        </div>
      </div>
    </div>
    <div class="col-md-3">

    </div>
  </div>
</div>

</body>

</html>