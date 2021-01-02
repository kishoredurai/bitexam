<?php

//header.php

include('Examination.php');

$exam = new Examination;

$exam->admin_session_private();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../style/bootstrap-datetimepicker.css" />
    <script src="../style/bootstrap-datetimepicker.js"></script>


</head>

<body>


    <nav class="navbar navbar-expand-sm  navbar-light   " style="background-color: #dedede ;">
        <div class="container" style="max-width: 1500px;">
            <a class="navbar-brand" href="index.php">
                <img src="https://www.bitsathy.ac.in/assets/images/headlogo.svg" width="180" height="40" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item dropdown">
                        <div class="topnav"><a class="nav-link dropdown" style="color: black;" class="nav-link" href="exam.php">Exams</a></div>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="exam_result.php">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>


                    <li class="nav-item dropdown">
                        <div class="topnav">
                            <a class="nav-link dropdown" style="color: black;" class="nav-link" href="#">Details</a></div>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="user.php">Students Details</a>
                            <a class="dropdown-item" href="staff.php">Staff Details</a>
                    </li>
                    <li class="nav-item">
                        <div class="topnav"> <a style="color: black;" class="nav-link" href="course.php">Student Courses</a></div>
                    </li>
                    <li class="nav-item">
                        <div class="topnav"> <a style="color: black;" class="nav-link" href="coe_feedback.php">Feedback</a></div>
                    </li>
                </ul>
                <?php
                if (isset($_SESSION['coe_id'])) {


                    $exam->query = "
            SELECT * FROM coe_table 
            WHERE coe_id = '" . $_SESSION['coe_id'] . "'
            ";

                    $result = $exam->query_result();
                    foreach ($result as $row)
                ?>
                    <form class="form-inline my-2 my-lg-0">
                        <div class="dropdown ">
                            <a class="dropdown-toggle" padding="10dp" type="button" data-toggle="dropdown"><img class="rounded-circle" width="35" height="30" alt="100x100" src="../include/bit1.png" data-holder-rendered="true"><b><?php echo $row["coe_name"]; ?></b>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <!-- <a class="dropdown-item " href="profile.php">Profile</a> -->
                                <a class="dropdown-item " href="change_password.php"><i class="fa fa-key" style="font-size:18px"></i>&nbsp;Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item " href="logout.php"><i class="fa fa-sign-out " style="font-size:18px"></i>&nbsp;Logout</a>
                        </div>
                        </ul>
            </div>
            </form>
        <?php
                }

        ?>
        </div>
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

        .dropdown:hover>.dropdown-menu {
            display: block;
        }
    </style>
    <div class="container-fluid">