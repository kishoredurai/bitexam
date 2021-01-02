<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="../include/bit1.png " type="image/icon type">
  	<title>Online Examination System - datastack</title>
      	<meta charset="utf-8">
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
	<div class="jumbotron text-center" style="margin-bottom:0;background-color:white;">
        <!-- <img src="https://www.bitsathy.ac.in/assets/images/headlogo.svg" class="img-fluid" width="700" alt="Online Examination System in PHP"> -->
       
  </div>

  <?php
  if(isset($_SESSION['user_id']))
  {
  ?>
  <!-- <nav class="navbar navbar-expand-sm bg-dark navbar-dark " >
    <a class="navbar-brand" href="index.php">User Side</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="enroll_exam.php">Enroll Exam</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="change_password.php">Change Password</a>
        </li>
        <li class="nav-item">
       <center>   <a class="nav-link" href="logout.php">Logout</a></ce
        </li>    
      </ul>
    </div>  
  </nav> -->

  <div class="container-fluid">
  <?php
  }
  ?>