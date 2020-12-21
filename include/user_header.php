<!--// source code modified by jacksonsilass@gmail.com +255 763169695 from weblessons -->
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" href="../include/bit1.png " type="image/icon type">
  	<title>Online Examination System - datastack</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../style1/bootstrap.min.css">
  <link rel="stylesheet" href="../style1/dataTables.bootstrap4.min.css">
  <script src="../style1/jquery.min.js"></script>
  <script src="../style1/parsley.js"></script>
  <script src="../style1/popper.min.js"></script>
  <script src="../style1/bootstrap.min.js"></script>
  <script src="../style1/dataTables.min.js"></script>
  <script src="../style1/dataTables.bootstrap4.min.js"></script>
  <link rel="stylesheet" href="../style/style.css" />
  <link rel="stylesheet" href="../style/TimeCircles.css" />
  <script src="../style/TimeCircles.js"></script>
  <link href="../style/button.css" rel="stylesheet" type="text/css">
</head>

<body>
  <!-- <div class="jumbotron text-center" style="margin-bottom:0; padding: 1rem 1rem;background-color:white;">
        <img src="https://www.bitsathy.ac.in/assets/images/headlogo.svg" class="img-fluid" width="900" alt="Online Examination System in PHP">
       
  </div> -->

  <?php
  if (isset($_SESSION['user_id'])) {
  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow p-2 fixed-top">
      <a class="navbar-brand" href="index.php" style="padding-left:20px;">
        <img src="https://www.bitsathy.ac.in/assets/images/headlogo.svg" width="180" height="39" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto" style="font-size:18px;">
        <li class="nav-item" style="padding-left:20px;">
            <div class="topnav"><a style="color: black;"  class="nav-link" href="index.php">Home</a></div>
          </li>
          <li class="nav-item" style="padding-left:20px;">
            <div class="topnav"><a style="color: black;"  class="nav-link" href="enroll_exam.php">Exam</a></div>
          </li>
          <li class="nav-item" style="padding-left:20px;">
            <div class="topnav"><a style="color: black;" class="nav-link" href="../student/feedback.php">Feedback</a></div>
          </li>
         
        </ul>

        <?php
        if (isset($_SESSION['user_id'])) {


          $exam->query = "
SELECT * FROM user_table 
WHERE user_id = '" . $_SESSION['user_id'] . "'
";

          $result = $exam->query_result();
          foreach ($result as $row)
        ?>


          <form class="form-inline my-2 my-lg-0">
            <div class="dropdown "> &nbsp;&nbsp;&nbsp;&nbsp;&emsp;&emsp;&emsp;
              <a class="dropdown-toggle"  type="button" data-toggle="dropdown">&nbsp;&nbsp;&nbsp;&nbsp; <img class="rounded-circle" width="35" height="35" alt="100x100" src="../upload/<?php echo $row["user_image"]; ?>" data-holder-rendered="true">&nbsp;<strong style="color:#89328c;font-family:comic Sans MS;font-size:18px;"><?php echo $row["user_name"]; ?></strong>
                <span class="caret"></span></a>
              <ul class="dropdown-menu ">
                <a class="dropdown-item " href="profile.php"><i class="fa fa-user-circle-o" style="font-size:18px"></i>&nbsp;Profile</a>
                <a class="dropdown-item " href="https://myaccount.google.com/signinoptions/password"><i class="fa fa-expeditedssl" style="font-size:18px"></i>&nbsp;Change Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out " style="font-size:18px"></i>&nbsp;Logout</a>
            </div>
            </ul>
      </div>
      </form>
      </div>
    </nav>
    <body oncontextmenu="return false;">

    <style>
      .topnav {
        overflow: hidden;
        font-size: 20px;
        float: left;
        color: blue;
      }

      .topnav a {

        text-decoration: none;

        border-bottom: 3px solid transparent;
      }

      .topnav a:hover {
        border-bottom: 3px solid #89328c;
      }
    </style>
    <div class="container-fluid">
  <?php
        }
      }
  ?>