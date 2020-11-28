<!--// source code modified by jacksonsilass@gmail.com +255 763169695 from weblessons -->
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Online Examination System in PHP</title>
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
  <!-- <div class="jumbotron text-center" style="margin-bottom:0; padding: 1rem 1rem;background-color:white;">
        <img src="https://www.bitsathy.ac.in/assets/images/headlogo.svg" class="img-fluid" width="900" alt="Online Examination System in PHP">
       
  </div> -->

  <?php
  if (isset($_SESSION['user_id'])) {
  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="index.php">
        <img src="https://www.bitsathy.ac.in/assets/images/headlogo.svg" width="180" height="40" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto" style="font-size:18px;">

          <li class="nav-item">
            <div class="topnav"><a style="color: black;" class="nav-link" href="enroll_exam.php">Enrolled Exam</a></div>
          </li>
          <li class="nav-item">
            <div class="topnav"><a style="color: black;" class="nav-link" href="../student/feedback.php">Feedback</a></div>
          </li>
          <li class="nav-item">
            <div class="topnav"> <a style="color: black;" class="nav-link" href="../student/event_calender.php">Upcoming Events</a></div>
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
            <div class="dropdown "> &nbsp;&nbsp;&nbsp;&nbsp;
              <a class="dropdown-toggle" padding="10dp" type="button" data-toggle="dropdown">&nbsp;&nbsp;&nbsp;&nbsp; <img class="rounded-circle" width="30" height="30" alt="100x100" src="../upload/<?php echo $row["user_image"]; ?>" data-holder-rendered="true">&nbsp;<?php echo $row["user_name"]; ?>
                <span class="caret"></span></a>
              <ul class="dropdown-menu ">
                <a class="dropdown-item " href="profile.php">Profile</a>
                <a class="dropdown-item " href="change_password.php">Change Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item " href="logout.php">Logout</a>
            </div>
            </ul>
      </div>
      </form>
      </div>
    </nav>
    <style>
      .topnav {
        overflow: hidden;
        font-size: 18px;
        float: left;
        color: blue;
      }

      .topnav a {

        text-decoration: none;

        border-bottom: 3px solid transparent;
      }

      .topnav a:hover {
        border-bottom: 3px solid red;
      }
    </style>
    <div class="container-fluid">
  <?php
        }
      }
  ?>