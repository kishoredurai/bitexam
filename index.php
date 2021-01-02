<?php

include('master/Examination.php');

$exam = new Examination;


if(isset($_SESSION["user_id"]))
{
header("location:/bitexam/student/index.php");
return;
}

if(isset($_SESSION["admin_id"]))
{
header("location:/bitexam/master/index.php");
return;
}

header("location:login.php");


?>