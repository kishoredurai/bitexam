<?php

include('../master/Examination.php');

$exam = new Examination;

$exam->user_session_private();

include('../include/db.php');
require_once '../include/db.php';




if(intval($_GET['del']))
{
$examid=intval($_GET['del']);
$id = $_SESSION['user_id'];          
$exam->query ="Select * from user_table where user_id= '$id';";
$results = $exam->query_result();
foreach($results as $rows)
{
    $receiver_email=$rows["user_email_address"];
    $user_name=$rows["user_name"];
}
$exam->query ="Select * from online_exam_table where online_exam_id = '$examid';";
$results = $exam->query_result();
foreach($results as $rows)
{
    $online_exam_title=$rows["online_exam_title"];
    
}
$subject="Online Examination Application";

$body = '<html><body><head>       
    <meta name="viewport" content="width=device-width, initial-scale=1"></head>
    <center><img src="https://img.collegedekhocdn.com/media/img/institute/logo/BIT-Tamilnadu-logo_1.png" width="750" height="160" ></center><br>
    <h3 style="font-size:180%;color:black;">Dear <b>'.$user_name.'</b></h3><p style="font-size:150%;">As your are tried to do malpractice on your '.$online_exam_title.' online examination . If there is any feedback regarding on  this , send your feedback through this <a href="http://localhost/bitexam/student/mal_fed.php?examid='.$examid.'">link</a> </p>
    <p style="font-size:150%;color:black;"><b>Thank you,</b></p>
	<p style="font-size:150%;color:black;">BIT Online Examination System</p>
    </body></html>';




$sql= "UPDATE user_exam_enroll_table SET exam_status='Completed',attendance_status='Present' ,remark='tabswitching' WHERE user_id = $id and exam_id= $examid;";
$result = mysqli_query($db, $sql);

$exam->send_email($receiver_email,$subject,$body);
header("location:enroll_exam.php");
}


if(intval($_GET['id']))
{	
$examid=intval($_GET['id']);
$id = $_SESSION['user_id'];
$sql= "UPDATE user_exam_enroll_table SET exam_status='Completed',attendance_status='Present',remark='submitted' WHERE user_id = $id and exam_id= $examid;";
$result = mysqli_query($db, $sql);
}

header("location:enroll_exam.php");
?>
