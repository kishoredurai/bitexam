<?php

//header.php

include('Examination.php');

$exam = new Examination;

$exam->admin_session_private();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Online Examination System in PHP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style1/bootstrap.min.css">
    <link rel="stylesheet" href="style1/Datatables.bootstrap4.min.css">
    <script src="style1/jquery.min.js"></script>
    <script src="style1/parsley.js"></script>
    <script src="style1/popper.min.js"></script>
    <script src="style1/bootstrap.min.js"></script>
    <script src="style1/dataTables.min.js"></script>
    <script src="style1/Datatables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="../style/bootstrap-datetimepicker.css" />
    <script src="../style/bootstrap-datetimepicker.js"></script>
    <link href="../style/button.css" rel="stylesheet" type="text/css">

</head>

<body>


    <nav class="navbar navbar-expand-sm  navbar-light   " style="background-color: #CBFE89 ;">
        <a class="navbar-brand" href="index.php">
            <img src="https://www.bitsathy.ac.in/assets/images/headlogo.svg" width="180" height="40" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <div class="topnav"><a style="color: black;" class="nav-link" href="exam.php">Add  Exam</a></div>
                </li>
                <li class="nav-item">
                    <div class="topnav"> <a style="color: black;" class="nav-link" href="course.php">Student Courses</a></div>
                </li>
                <li class="nav-item">
                    <div class="topnav"><a style="color: black;" class="nav-link" href="user.php">User</a></div>
                </li>
               
                <li class="nav-item">
                    <div class="topnav"> <a style="color: black;" class="nav-link" href="staff_feedback.php">Feedback</a></div>
                </li>
            </ul>
        <?php
        if (isset($_SESSION['admin_id'])) {


          $exam->query = "
SELECT * FROM admin_table 
WHERE admin_id = '" . $_SESSION['admin_id'] . "'
";

          $result = $exam->query_result();
          foreach ($result as $row)
        ?>
            <form class="form-inline my-2 my-lg-0">
            <div class="dropdown "> &emsp;&nbsp;&nbsp;&nbsp;
              <a class="dropdown-toggle" padding="10dp" type="button" data-toggle="dropdown">&nbsp;&nbsp;&nbsp;&nbsp; <img class="rounded-circle" width="30" height="30" alt="100x100" src="https://upload.wikimedia.org/wikipedia/en/7/77/Bannari_Amman_Institute_of_Technology_logo.png" data-holder-rendered="true">&nbsp;<?php echo $row["admin_name"]; ?>
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
      <?php
        }
      
  ?>
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